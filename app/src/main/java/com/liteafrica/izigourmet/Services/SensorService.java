package com.liteafrica.izigourmet.Services;


import android.app.ActivityManager;
import android.app.Service;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationManager;
import android.os.Build;
import android.os.Bundle;
import android.os.IBinder;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.liteafrica.izigourmet.delivery.DrivermapApp;

import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;


public class SensorService extends Service {
    public final static int REQUEST_CODE = -1010101;
    private static final int REQUEST_CHECK_SETTINGS = 1001;
    private static final String TAG = "MyLocationService";
    private static final int LOCATION_INTERVAL = 1000;
    private static final float LOCATION_DISTANCE = 10f;
    public int counter = 0;
    LocationListener[] mLocationListeners = new LocationListener[]{
            new LocationListener(LocationManager.PASSIVE_PROVIDER)
    };
    private Context mContext;
    private String _PhoneNo;
    private double My_long = 0, My_lat = 0;
    private com.liteafrica.izigourmet.PrefManager pref;
    private LocationManager mLocationManager = null;
    private Location mLastLocation;
    private Location mCurrentLocation;
    private String Tracking_type = "";
    private DatabaseReference mDatabase;
    private WindowManager mWindowManager;
    private View mFloatingView;

    public SensorService(Context applicationContext) {
        super();
        mContext = applicationContext;
        Log.i("HERE", "here I am!");
    }


    public SensorService() {

    }

    public static boolean isAppIsInBackground(Context context) {
        boolean isInBackground = true;
        ActivityManager am = (ActivityManager) context.getSystemService(Context.ACTIVITY_SERVICE);
        if (Build.VERSION.SDK_INT > Build.VERSION_CODES.KITKAT_WATCH) {
            List<ActivityManager.RunningAppProcessInfo> runningProcesses = null;
            if (am != null) {
                runningProcesses = am.getRunningAppProcesses();
                for (ActivityManager.RunningAppProcessInfo processInfo : runningProcesses) {
                    if (processInfo.importance == ActivityManager.RunningAppProcessInfo.IMPORTANCE_FOREGROUND) {
                        for (String activeProcess : processInfo.pkgList) {
                            if (activeProcess.equals(context.getPackageName())) {
                                isInBackground = false;
                            }
                        }
                    }
                }
            }

        } else {
            List<ActivityManager.RunningTaskInfo> taskInfo = null;
            if (am != null) {
                taskInfo = am.getRunningTasks(1);
                ComponentName componentInfo = taskInfo.get(0).topActivity;
                if (componentInfo.getPackageName().equals(context.getPackageName())) {
                    isInBackground = false;
                }
            }

        }

        return isInBackground;
    }

    @Override
    public void onCreate() {
        mDatabase = FirebaseDatabase.getInstance().getReference();
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        initializeLocationManager();

        try {
            mLocationManager.requestLocationUpdates(
                    LocationManager.GPS_PROVIDER,
                    LOCATION_INTERVAL,
                    LOCATION_DISTANCE,
                    mLocationListeners[0]
            );

        } catch (SecurityException ex) {
            Log.i(TAG, "fail to request location update, ignore", ex);
        } catch (IllegalArgumentException ex) {
            Log.d(TAG, "network provider does not exist, " + ex.getMessage());
        }
        Log.i(TAG, "onCreate");


    }

    private void initializeLocationManager() {
        Log.e(TAG, "initializeLocationManager - LOCATION_INTERVAL: " + LOCATION_INTERVAL + " LOCATION_DISTANCE: " + LOCATION_DISTANCE);
        if (mLocationManager == null) {
            mLocationManager = (LocationManager) getApplicationContext().getSystemService(Context.LOCATION_SERVICE);

        }
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        super.onStartCommand(intent, flags, startId);
        return START_STICKY;
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        Log.i("EXIT", "ondestroy!");
        Intent broadcastIntent = new Intent("com.tez.driver.Services.SensorService");
        sendBroadcast(broadcastIntent);
        if (mFloatingView != null) mWindowManager.removeView(mFloatingView);

    }


    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    private void go_now() {

        if (pref.getGoTRide() == 0) {
            pref.setGoTRide(1);
            Intent i = new Intent(getApplicationContext(), DrivermapApp.class);
            i.putExtra("mylat", My_lat);
            i.putExtra("mylong", My_long);
            i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(i);
        }

    }

    private class LocationListener implements android.location.LocationListener {


        public LocationListener(String provider) {
            Log.d(TAG, "LocationListener " + provider);
            mLastLocation = new Location(provider);
            if (mDatabase != null && _PhoneNo != null && pref != null) {
                if (pref.getOffline() == 0) {
                    mDatabase.child("IziGourmet").addValueEventListener(new FirebaseDataListener_ride());
                }

            }
        }

        @Override
        public void onLocationChanged(Location location) {
            Log.e(TAG, "onLocationChanged: " + location);
            if (mDatabase != null && _PhoneNo != null && pref != null) {
                DecimalFormat dft = new DecimalFormat("0.000000");
                SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd", Locale.CHINA);
                Calendar cal = Calendar.getInstance();
                String date = format.format(cal.getTime());
                My_lat = location.getLatitude();
                My_long = location.getLongitude();
                mDatabase.child("Driver_Online").child(_PhoneNo).child("Driver_Online_Date").setValue(date);
                if (isAppIsInBackground(getApplicationContext())) {
                    mDatabase.child("Driver_Online").child(_PhoneNo).child("First_Latitude").setValue(dft.format(location.getLatitude()));
                    mDatabase.child("Driver_Online").child(_PhoneNo).child("First_Longitude").setValue(dft.format(location.getLongitude()));

                }

                if (pref.getOffline() == 0) {
                    mDatabase.child("IziGourmet").addValueEventListener(new FirebaseDataListener_ride());
                }

            }

        }

        @Override
        public void onProviderDisabled(String provider) {
            Log.e(TAG, "onProviderDisabled: " + provider);
            if (pref.getUniqueRide() != null) {
                Intent launchGoogleChrome = getPackageManager().getLaunchIntentForPackage("com.tez.driver");
                startActivity(launchGoogleChrome);
            }
        }

        @Override
        public void onProviderEnabled(String provider) {
            Log.e(TAG, "onProviderEnabled: " + provider);
        }

        @Override
        public void onStatusChanged(String provider, int status, Bundle extras) {
            Log.e(TAG, "onStatusChanged: " + provider);
            if (mDatabase != null && _PhoneNo != null && pref != null) {

                if (pref.getOffline() == 0) {
                    mDatabase.child("IziGourmet").addValueEventListener(new FirebaseDataListener_ride());
                }
            }
        }
    }

    private class FirebaseDataListener_ride implements ValueEventListener {


        private double User_lat, User_long;
        private boolean got_ride = false;

        @Override
        public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
            if (dataSnapshot.getChildrenCount() != 0) {
                Log.w(TAG, "dataSnapshot, " + dataSnapshot.getChildrenCount());
                for (DataSnapshot child : dataSnapshot.getChildren()) {
                    if (child != null) {
                        String key = child.getKey();
                        Log.w(TAG, "key, " + key);
                        Object value = child.getValue();
                        if (value != null && ((Map) value).get("OTP") != null) {
                            go_now();
                        }

                    }
                }

            }
        }

        @Override
        public void onCancelled(@NonNull DatabaseError databaseError) {

        }
    }
}