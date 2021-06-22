package com.liteafrica.izigourmet.delivery;

import android.app.ActivityManager;
import android.app.AlarmManager;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.media.MediaPlayer;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.localbroadcastmanager.content.LocalBroadcastManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.gms.maps.model.LatLng;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.google.maps.android.SphericalUtil;
import com.liteafrica.izigourmet.Alarm.AlarmNotificationService;
import com.liteafrica.izigourmet.Alarm.AlarmReceiver;
import com.liteafrica.izigourmet.Alarm.AlarmSoundService;
import com.liteafrica.izigourmet.FCM.NotificationUtils;
import com.liteafrica.izigourmet.R;
import com.liteafrica.izigourmet.Services.SensorService;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.net.UnknownHostException;
import java.util.ArrayList;
import java.util.HashMap;

import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;


public class GetRide extends AppCompatActivity implements MediaPlayer.OnPreparedListener {
    private static final String TAG = GetRide.class.getSimpleName();
    private static final int ALARM_REQUEST_CODE = 10009;
    private ProgressBar progressBar;
    private RecyclerView laterRv;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _PhoneNo;
    private double My_lat = 0, My_long = 0, To_lat = 0, To_long = 0;
    private Toolbar toolbar;
    private String Vehicle;
    private DatabaseReference mDatabase;
    private MediaPlayer _Player = null;
    private BroadcastReceiver mRegistrationBroadcastReceiver;
    private PendingIntent pendingIntent;
    private boolean _played = false;
    private boolean _first = false;
    private long position;
    private SensorService mSensorService;
    private Intent mServiceIntent;
    private TextView t104;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.later_dates);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        progressBar = findViewById(R.id.progressBar21);
        progressBar.setVisibility(View.VISIBLE);
        toolbar = findViewById(R.id.toolbar_later_dates);
        t104 = findViewById(R.id.textView104);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        laterRv = findViewById(R.id.laterRv);
        progressBar.setVisibility(View.VISIBLE);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                pref.setGoTRide(0);
                Intent o = new Intent(GetRide.this, DrivermapApp.class);
                o.putExtra("my_lat", My_lat);
                o.putExtra("my_long", My_long);
                startActivity(o);
                finish();
                overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);
            }
        });
        mDatabase = FirebaseDatabase.getInstance().getReference();

        mRegistrationBroadcastReceiver = new BroadcastReceiver() {
            @Override
            public void onReceive(Context context, Intent intent) {
                if (intent.getAction().equals(com.liteafrica.izigourmet.Config_URL.PUSH_NOTIFICATION)) {
                    RegisterAlarmBroadcast();
                }
            }
        };

        Intent alarmIntent = new Intent(GetRide.this, AlarmReceiver.class);
        pendingIntent = PendingIntent.getBroadcast(GetRide.this, ALARM_REQUEST_CODE, alarmIntent, 0);
        if (pendingIntent != null) {
            stopAlarmManager();
        }
        mSensorService = new SensorService(GetRide.this);
        mServiceIntent = new Intent(GetRide.this, mSensorService.getClass());

    }

    @Override
    public void onLowMemory() {
        super.onLowMemory();
        if (!isMyServiceRunning(mSensorService.getClass())) {
            stopService(mServiceIntent);
            recreate();
        }
    }

    private boolean isMyServiceRunning(Class<?> serviceClass) {
        ActivityManager manager = (ActivityManager) getSystemService(Context.ACTIVITY_SERVICE);
        if (manager != null) {
            for (ActivityManager.RunningServiceInfo service : manager.getRunningServices(Integer.MAX_VALUE)) {
                if (serviceClass.getName().equals(service.service.getClassName())) {
                    Log.i("isMyServiceRunning?", true + "");
                    return true;
                }
            }
        }
        Log.i("isMyServiceRunning?", false + "");
        return false;
    }


    @Override
    protected void onResume() {
        super.onResume();
        if (!isMyServiceRunning(mSensorService.getClass())) {
            stopService(mServiceIntent);
        }
        Intent i = getIntent();
        My_lat = i.getDoubleExtra("mylat", 0);
        My_long = i.getDoubleExtra("mylong", 0);

        if (pref.getOffline() == 0) {
            mDatabase.child("Order").addValueEventListener(new FirebaseDataListener());
        }


        progressBar.setVisibility(View.GONE);
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver,
                new IntentFilter(com.liteafrica.izigourmet.Config_URL.REGISTRATION_COMPLETE));
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver,
                new IntentFilter(com.liteafrica.izigourmet.Config_URL.PUSH_NOTIFICATION));
        NotificationUtils.clearNotifications(getApplicationContext());

    }

    @Override
    public void onDestroy() {
        super.onDestroy();

    }


    @Override
    protected void onStop() {
        super.onStop();

    }

    private void _remove() {
        stopAlarmManager();
        pref.setGoTRide(0);
        Intent o = new Intent(GetRide.this, DrivermapApp.class);
        o.putExtra("my_lat", My_lat);
        o.putExtra("my_long", My_long);
        startActivity(o);
        finish();
        overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);
    }

    private void RegisterAlarmBroadcast() {
        _played = true;
        triggerAlarmManager(System.currentTimeMillis());

    }

    public void onPrepared(MediaPlayer player) {
        player.start();
    }

    public void triggerAlarmManager(long alarmTriggerTime) {
        AlarmManager manager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);//get instance of alarm manager
        manager.set(AlarmManager.RTC_WAKEUP, (alarmTriggerTime), pendingIntent);
        //sst alarm manager with entered timer by converting into milliseconds
    }

    public void stopAlarmManager() {

        AlarmManager manager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);
        if (manager != null) {
            manager.cancel(pendingIntent);
        }
        stopService(new Intent(GetRide.this, AlarmSoundService.class));
        NotificationManager notificationManager = (NotificationManager) this
                .getSystemService(Context.NOTIFICATION_SERVICE);
        if (notificationManager != null) {
            notificationManager.cancel(AlarmNotificationService.NOTIFICATION_ID);
        }

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_white, menu);
        return true;

    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        //replaces the default 'Back' button action
        stopAlarmManager();
        pref.setGoTRide(0);
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            if (!GetRide.this.isFinishing()) {
                AlertDialog.Builder builder = new AlertDialog.Builder(GetRide.this, R.style.AlertDialogTheme)
                        .setIcon(R.mipmap.ic_launcher)
                        .setTitle("Are you sure to exit?")
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {

                                overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);
                                finish();
                                dialog.cancel();
                            }
                        })
                        .setNegativeButton("No", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                dialog.cancel();
                            }
                        });
                builder.show();
            }
        }
        return true;
    }

    private class FirebaseDataListener implements ValueEventListener {

        @Override
        public void onDataChange(DataSnapshot dataSnapshot) {
            long count = dataSnapshot.getChildrenCount();
            if (count != 0) {
                if (position != count) {
                    position = count;
                    new GetCustomer().execute();
                }
            } else {

                _remove();
            }
        }


        @Override
        public void onCancelled(DatabaseError databaseError) {

        }
    }

    private class GetCustomer extends AsyncTask<Void, Integer, String> {


        private ArrayList<Drivers> mItems = new ArrayList<Drivers>();

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            progressBar.setVisibility(View.VISIBLE);
        }

        protected String doInBackground(Void... args) {
            return uploadFile();
        }

        private String uploadFile() {
            // TODO Auto-generated method stub
            String res = null;

            try {


                RequestBody requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("_mId", _PhoneNo)
                        .build();

                Request request = new Request.Builder()
                        .url(com.liteafrica.izigourmet.Config_URL.GET_PENDING_RIDES)
                        .post(requestBody)
                        .build();
                OkHttpClient client = new OkHttpClient();
                okhttp3.Response response = client.newCall(request).execute();
                res = response.body().string();
                if (res != null) {
                    try {
                        JSONObject jsonObj = new JSONObject(res);

                        JSONArray Book_Ride_Now = jsonObj.getJSONArray("ride");
                        if (Book_Ride_Now.length() != 0) {
                            for (int i = 0; i < Book_Ride_Now.length(); i++) {
                                JSONObject c = Book_Ride_Now.getJSONObject(i);
                                if (!c.isNull("Unique_Ride_Code")) {
                                    double l1 = c.getDouble("From_Latitude");
                                    double l2 = c.getDouble("From_Longitude");
                                    double dist = SphericalUtil.computeDistanceBetween(new LatLng(My_lat, My_long), new LatLng(l1, l2)) / 1000;

                                    Drivers item = new Drivers();
                                    item.setUnique_ride(c.getString("Unique_Ride_Code"));
                                    item.setUser_from(c.getString("From_Address"));
                                    item.setUser_to(c.getString("To_Address"));
                                    item.setUser_from_lat(String.valueOf(c.getDouble("From_Latitude")));
                                    item.setUser_from_long(String.valueOf(c.getDouble("From_Longitude")));
                                    item.setUser_to_lat(String.valueOf(c.getDouble("To_Latitude")));
                                    item.setUser_to_long(String.valueOf(c.getDouble("To_Longitude")));
                                    item.setOTP(String.valueOf(c.getInt("OTP")));
                                    item.setUser_mobile(c.getString("UserMobile"));
                                    mItems.add(item);


                                }
                            }
                        }
                    } catch (final JSONException e) {
                        Log.e("HI", "Json parsing error: " + e.getMessage());


                    }

                }
                Log.e("TAG", "Response : " + res);

                return res;

            } catch (UnknownHostException | UnsupportedEncodingException e) {
                Log.e("TAG", "Error: " + e.getLocalizedMessage());
            } catch (Exception e) {
                Log.e("TAG", "Other Error: " + e.getLocalizedMessage());
            }


            return res;

        }

        protected void onPostExecute(String file_url) {
            progressBar.setVisibility(View.GONE);
            if (mItems.size() != 0) {
                t104.setVisibility(View.GONE);
                laterRv.setVisibility(View.VISIBLE);
                if (!_played) {
                    RegisterAlarmBroadcast();
                }
                progressBar.setVisibility(View.GONE);
                Ride_adapter sAdapter = new Ride_adapter(GetRide.this, mItems);
                sAdapter.notifyDataSetChanged();
                sAdapter.setMobile(_PhoneNo);
                sAdapter.setPef(pref);
                sAdapter.setMyLat(My_lat, My_long);
                laterRv.setAdapter(sAdapter);
                LinearLayoutManager mLayoutManager = new LinearLayoutManager(GetRide.this);
                mLayoutManager.setOrientation(LinearLayoutManager.VERTICAL);
                laterRv.setLayoutManager(mLayoutManager);

            } else {

                _remove();
                laterRv.setVisibility(View.GONE);

            }

        }
    }

}
