package com.liteafrica.izigourmet.Activites;

import android.Manifest;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentSender;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.net.Uri;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.os.Looper;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.DialogFragment;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.NetworkError;
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GoogleApiAvailability;
import com.google.android.gms.common.api.ApiException;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.ResolvableApiException;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationCallback;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationResult;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.LocationSettingsRequest;
import com.google.android.gms.location.LocationSettingsResponse;
import com.google.android.gms.location.LocationSettingsResult;
import com.google.android.gms.location.LocationSettingsStatusCodes;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.bottomsheet.BottomSheetBehavior;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.InstanceIdResult;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.Activites.Main_Page.UserSuccess;
import com.liteafrica.izigourmet.BuildConfig;
import com.liteafrica.izigourmet.R;
import com.liteafrica.izigourmet.Requests.Tabs_past_future_ride;
import com.liteafrica.izigourmet.delivery.DrivermapApp;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;


public class Splash_screen extends AppCompatActivity implements GoogleApiClient.ConnectionCallbacks,
        GoogleApiClient.OnConnectionFailedListener {
    public static final int MULTIPLE_PERMISSIONS = 10;
    private static final String TAG = Splash_screen.class.getSimpleName();
    private static final int REQUEST_RESOLVE_ERROR = 1001;
    // Unique tag for the error dialog fragment
    private static final String DIALOG_ERROR = "dialog_error";
    private static final int REQUEST_PERMISSIONS_REQUEST_CODE = 34;
    private static final int REQUEST_CHECK_SETTINGS = 0x1;
    private static final LatLngBounds BOUNDS_MOUNTAIN_VIEW = new LatLngBounds(
            new LatLng(25.00000, 91.00000), new LatLng(27.99999, 91.99999));
    private static final float POLYLINE_WIDTH = 8;
    private final int REQUEST_LOCATION = 200;
    double My_lat, My_long;
    DecimalFormat dft = new DecimalFormat("0.00");
    DecimalFormat dfto = new DecimalFormat("0.000000");
    BottomSheetBehavior sheetBehavior;
    Boolean isInternetPresent = false;
    private GoogleApiClient mGoogleApiClient;
    private PendingResult<LocationSettingsResult> result;
    private LocationSettingsRequest.Builder builder;
    // Bool to track whether the app is already resolving an error
    private boolean mResolvingError = false;
    private String strAdd;
    private FusedLocationProviderClient mFusedLocationClient;
    private LocationRequest mLocationRequest;
    private LocationCallback mLocationCallback;
    private Location mCurrentLocation;
    private Boolean mRequestingLocationUpdates;
    private com.liteafrica.izigourmet.PrefManager pref;
    private boolean permissionsAllowd;
    private RelativeLayout Splash;
    private ProgressBar progressBar;
    private CoordinatorLayout coordinatorLayout;
    private boolean dont = false;
    private int Online;
    private String _phoneNo;
    private DatabaseReference mDatabase;
    private boolean launced = false;
    private String regId;
    private double User_review = 0;
    private String User_image, User_name;
    private int User_ID = 0;
    private double User_From_lat, User_From_long, User_To_lat, User_To_long;
    private boolean going = false;
    private int version_ = 3, imp = 1;
    private int version_1 = 0, _imp_1 = 1;
    private boolean _first = false;
    private Thread splashTread;
    private boolean _second = false;
    private MyCountDownTimer myCountDownTimer;
    private int _count = 0;
    private boolean _got;
    private String token = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        mRequestingLocationUpdates = false;
        mFusedLocationClient = LocationServices.getFusedLocationProviderClient(this);
        checkAndRequestPermissions();
        createLocationCallback();
        buildLocationSettingsRequest();
        rebuildGoogleApiClient();
        if (mGoogleApiClient != null && mGoogleApiClient.isConnected()) {
            onConnected(null);
        }
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        setContentView(R.layout.splash_screen);
        progressBar = findViewById(R.id.progressBarSplash);
        coordinatorLayout = findViewById(R.id
                .cor_home_main);


        mDatabase = FirebaseDatabase.getInstance().getReference();



        pref.set_cID(1);

    }

    private void StartAnimations() {
        myCountDownTimer = new MyCountDownTimer(3000, 1000);
        myCountDownTimer.start();
        launchHomeScreen();
    }

    protected LocationRequest createLocationRequest() {
        mLocationRequest = new LocationRequest();
        mLocationRequest.setInterval(1000);
        mLocationRequest.setFastestInterval(2000);
        mLocationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        return mLocationRequest;
    }

    private void createLocationCallback() {
        mLocationCallback = new LocationCallback() {
            @Override
            public void onLocationResult(LocationResult locationResult) {
                super.onLocationResult(locationResult);
                mCurrentLocation = locationResult.getLastLocation();
                updateLocationUI(mCurrentLocation);
            }
        };
    }

    private void buildLocationSettingsRequest() {
        LocationSettingsRequest.Builder builder = new LocationSettingsRequest.Builder();
        builder.addLocationRequest(mLocationRequest);

    }

    protected synchronized void rebuildGoogleApiClient() {
        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .enableAutoManage(this, 0, this)
                .addConnectionCallbacks(this /* ConnectionCallbacks */)
                .addOnConnectionFailedListener(new GoogleApiClient.OnConnectionFailedListener() {
                    @Override
                    public void onConnectionFailed(ConnectionResult connectionResult) {
                        googleApiClientConnectionStateChange(true);
                    }
                })


                .addApi(LocationServices.API)
                .build();

    }

    private void googleApiClientConnectionStateChange(final boolean connected) {
        final Context appContext = this.getApplicationContext();

    }

    @Override
    public void onConnected(Bundle bundle) {
        builder = new LocationSettingsRequest.Builder().addLocationRequest(createLocationRequest());
        Task<LocationSettingsResponse> task = LocationServices.getSettingsClient(this).checkLocationSettings(builder.build());
        task.addOnCompleteListener(new OnCompleteListener<LocationSettingsResponse>() {
            @Override
            public void onComplete(@NonNull Task<LocationSettingsResponse> task) {
                try {
                    LocationSettingsResponse response = task.getResult(ApiException.class);
                    // All location settings are satisfied. The client can initialize location
                    // requests here.
                    startLocationUpdat();
                } catch (ApiException exception) {
                    switch (exception.getStatusCode()) {
                        case LocationSettingsStatusCodes.RESOLUTION_REQUIRED:
                            // Location settings are not satisfied. But could be fixed by showing the
                            // user a dialog.
                            try {
                                // Cast to a resolvable exception.
                                ResolvableApiException resolvable = (ResolvableApiException) exception;
                                // Show the dialog by calling startResolutionForResult(),
                                // and check the result in onActivityResult().
                                resolvable.startResolutionForResult(Splash_screen.this, REQUEST_CHECK_SETTINGS);
                                break;
                            } catch (IntentSender.SendIntentException e) {
                                // Ignore the error.
                            } catch (ClassCastException e) {
                                // Ignore, should be an impossible error.
                                Log.w(" ClassCastException", "Canont get Address!" + e.getLocalizedMessage());
                            }
                            break;
                        case LocationSettingsStatusCodes.SETTINGS_CHANGE_UNAVAILABLE:
                            // Location settings are not satisfied. However, we have no way to fix the
                            // settings so we won't show the dialog.

                            break;
                    }
                }
            }
        });
    }

    @Override
    public void onConnectionSuspended(int cause) {
        googleApiClientConnectionStateChange(false);
        mGoogleApiClient.connect();
    }

    @Override
    public void onConnectionFailed(ConnectionResult result) {
        if (mResolvingError) {

        } else if (result.hasResolution()) {
            try {
                mResolvingError = true;
                result.startResolutionForResult(this, REQUEST_RESOLVE_ERROR);
            } catch (IntentSender.SendIntentException e) {
                mGoogleApiClient.connect();
            }
        } else {
            //    showErrorDialog(result.getErrorCode());
            mResolvingError = true;
        }
    }

    public void onDialogDismissed() {
        mResolvingError = false;
    }

    private void stopLocationUpdates() {
        if (!mRequestingLocationUpdates) {
            Log.d(TAG, "stopLocationUpdates: updates never requested, no-op.");
            return;
        }

        mFusedLocationClient.removeLocationUpdates(mLocationCallback)
                .addOnCompleteListener(this, new OnCompleteListener<Void>() {
                    @Override
                    public void onComplete(@NonNull Task<Void> task) {
                        mRequestingLocationUpdates = false;

                    }
                });
    }

    private void startLocationUpdat() {
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            return;
        }
        if (mFusedLocationClient != null) {
            mFusedLocationClient.requestLocationUpdates(createLocationRequest(), new LocationCallback() {
                        @Override
                        public void onLocationResult(LocationResult locationResult) {
                            List<Location> locationList = locationResult.getLocations();
                            if (locationList.size() > 0) {
                                Location location = locationList.get(locationList.size() - 1);
                                Log.i("MapsActivity", "Location: " + location);
                                updateLocationUI(location);
                            }

                        }
                    },
                    Looper.myLooper());
        }
    }

    private void updateLocationUI(Location location) {


        if (!_first) {
            _first = true;
            My_lat = location.getLatitude();
            My_long = location.getLongitude();
            if (pref.getResposibility() == 1 || pref.getResposibility() == 0) {
                pref.setDropLat(String.valueOf(My_lat));
                pref.setDropLong(String.valueOf(My_long));
                getCompleteAddressString(My_lat, My_long);
            }
            StartAnimations();

        }
    }

    private String getCompleteAddressString(double LATITUDE, double LONGITUDE) {

        Geocoder geocoder = new Geocoder(this, Locale.getDefault());
        try {
            List<Address> addresses = geocoder.getFromLocation(LATITUDE, LONGITUDE, 1);
            if (addresses != null && addresses.size() != 0) {
                Address returnedAddress = addresses.get(0);
                StringBuilder strReturnedAddress = new StringBuilder();

                for (int i = 0; i <= returnedAddress.getMaxAddressLineIndex(); i++) {
                    strReturnedAddress.append(returnedAddress.getAddressLine(i));
                }
                strAdd = strReturnedAddress.toString();
                pref.setDropAt(strAdd);
                Log.w(" address", strReturnedAddress.toString());
            } else {
                strAdd = LATITUDE + "," + LONGITUDE;
                Log.w(" address", "No Address returned!");
            }
        } catch (Exception e) {
            e.printStackTrace();
            strAdd = LATITUDE + "," + LONGITUDE;
            Log.w(" loction address", "Canont get Address!");
        }
        return strAdd;
    }

    @Override
    protected void onStart() {
        super.onStart();
    }

    @Override
    public void onPause() {
        super.onPause();


        if (myCountDownTimer != null) {
            myCountDownTimer.cancel();
        }

    }

    @Override
    protected void onStop() {
        super.onStop();

        if (myCountDownTimer != null) {
            myCountDownTimer.cancel();
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();

        if (myCountDownTimer != null) {
            myCountDownTimer.cancel();
        }

    }

    @Override
    protected void onResume() {
        super.onResume();
        if (permissionsAllowd) {

            startLocationUpdat();
        } else {
            checkAndRequestPermissions();
        }


    }

    private void checkAndRequestPermissions() {
        int permissionLocation = ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION);


        List<String> listPermissionsNeeded = new ArrayList<>();


        if (permissionLocation != PackageManager.PERMISSION_GRANTED) {
            listPermissionsNeeded.add(Manifest.permission.ACCESS_FINE_LOCATION);
        }

        if (!listPermissionsNeeded.isEmpty()) {
            ActivityCompat.requestPermissions(this, listPermissionsNeeded.toArray(new String[listPermissionsNeeded.size()]), MULTIPLE_PERMISSIONS);

        } else {
            permissionsAllowd = true;
            startLocationUpdat();
        }

    }

    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String[] permissions, int[] grantResults) {
        Log.d(TAG, "Permission callback called-------");
        switch (requestCode) {
            case MULTIPLE_PERMISSIONS: {

                Map<String, Integer> perms = new HashMap<>();
                // Initialize the map with both permissions
                perms.put(Manifest.permission.ACCESS_FINE_LOCATION, PackageManager.PERMISSION_GRANTED);

                // Fill with actual results from user
                if (grantResults.length > 0) {
                    for (int i = 0; i < permissions.length; i++)
                        perms.put(permissions[i], grantResults[i]);
                    // Check for both permissions
                    if (perms.get(Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED
                    ) {
                        Log.d(TAG, "sms & location services permission granted");
                        // process the normal flow

                        startLocationUpdat();


                    } else {
                        Log.d(TAG, "Some permissions are not granted ask again ");
                        explain("You need to give some mandatory permissions to continue");
                    }
                }
            }
            break;

        }


    }

    private void explain(String msg) {
        new AlertDialog.Builder(Splash_screen.this)

                .setMessage(msg)
                .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        startActivity(new Intent(android.provider.Settings.ACTION_APPLICATION_DETAILS_SETTINGS, Uri.parse("package:" + BuildConfig.APPLICATION_ID)));
                        dialog.cancel();
                    }
                })
                .setNegativeButton("No", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        finish();
                        dialog.cancel();
                    }
                }).show();

    }

    private void launchHomeScreen() {
        if (_phoneNo == null) {
            _phoneNo = "999999999";
        }
        if (pref.getRegID() == null) {
            FirebaseInstanceId.getInstance().getInstanceId()
                    .addOnCompleteListener(new OnCompleteListener<InstanceIdResult>() {


                        @Override
                        public void onComplete(@NonNull Task<InstanceIdResult> task) {
                            if (!task.isSuccessful()) {
                                Log.w(TAG, "getInstanceId failed", task.getException());
                                return;
                            }
                            token = task.getResult().getToken();
                            pref.setRegID(token);
                        }
                    });
        } else {
            token = pref.getRegID();
        }
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_DETAILS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        JSONObject jsonObj = null;
                        try {
                            jsonObj = new JSONObject(response);




                            JSONArray settings = jsonObj.getJSONArray("settings");
                            for (int i = 0; i < settings.length(); i++) {
                                JSONObject c = settings.getJSONObject(i);
                                if (!c.isNull("WhatsApp")) {
                                    pref.setWhatsApp(c.getString("WhatsApp"));
                                }
                                if (!c.isNull("FacebookPage")) {
                                    pref.setFacebook(c.getString("FacebookPage"));
                                }
                                if (!c.isNull("InstagramPage")) {
                                    pref.setInstagram(c.getString("InstagramPage"));
                                }
                                if (!c.isNull("YoutubePlaylis")) {
                                    pref.setYoutubeVideos(c.getString("YoutubePlaylis"));
                                }
                            }


                            JSONArray version = jsonObj.getJSONArray("version");

                            for (int i = 0; i < version.length(); i++) {
                                JSONObject c = version.getJSONObject(i);

                                if (!c.isNull("Version")) {
                                    _got = true;
                                    version_1 = c.getInt("Version");
                                    _imp_1 = c.getInt("Importance");
                                }
                            }
                            JSONArray shops = jsonObj.getJSONArray("shops");
                            for (int i = 0; i < shops.length(); i++) {
                                JSONObject c = shops.getJSONObject(i);

                                if (!c.isNull("Latitude")) {
                                    pref.setPickLat(c.getString("Latitude"));
                                    pref.setPickLong(c.getString("Longitude"));
                                }
                            }

                            JSONArray login = jsonObj.getJSONArray("login");
                            for (int i = 0; i < login.length(); i++) {
                                JSONObject c = login.getJSONObject(i);
                                if (!c.isNull("Phone_No")) {
                                    User_image = c.getString("Photo");
                                    User_name = c.getString("Name");
                                    User_ID = c.getInt("ID");
                                    User_review = c.getDouble("Rating");

                                }
                            }


                            JSONArray Book_Ride_Now = jsonObj.getJSONArray("Book_Ride_Now");
                            if (Book_Ride_Now.length() != 0) {
                                for (int i = 0; i < Book_Ride_Now.length(); i++) {
                                    JSONObject c = Book_Ride_Now.getJSONObject(i);
                                    if (!c.isNull("Unique_Ride_Code") && !c.getString("Unique_Ride_Code").contains("null")) {
                                        pref.setUniqueRide(c.getString("Unique_Ride_Code"));
                                        pref.setDelivery(1);
                                        pref.setTotal(dft.format(Double.parseDouble(c.getString("Cost"))));
                                        pref.set_food_items(c.getInt("CountNoofItems"));
                                        pref.setPayment(c.getInt("PaymentMode"));

                                    } else {
                                        erase();
                                    }

                                }
                            } else {
                                erase();

                            }


                        } catch (JSONException ex) {
                            ex.printStackTrace();
                        }


                        progressBar.setVisibility(View.GONE);


                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

                if (error instanceof TimeoutError || error instanceof NoConnectionError) {
                    Snackbar snackbar = Snackbar
                            .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_INDEFINITE)
                            .setAction("Refresh", new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    recreate();
                                }
                            });
                    snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
                    snackbar.show();
                } else if (error instanceof AuthFailureError) {
                    Snackbar snackbar = Snackbar
                            .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_INDEFINITE)
                            .setAction("Refresh", new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    recreate();
                                }
                            });
                    snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
                    snackbar.show();
                } else if (error instanceof ServerError) {
                    Snackbar snackbar = Snackbar
                            .make(coordinatorLayout, "Server Error.Please try another time", Snackbar.LENGTH_INDEFINITE)
                            .setAction("Refresh", new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    recreate();
                                }
                            });
                    snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
                    snackbar.show();
                } else if (error instanceof NetworkError) {
                    Snackbar snackbar = Snackbar
                            .make(coordinatorLayout, "Network Error. Please try another time", Snackbar.LENGTH_INDEFINITE)
                            .setAction("Refresh", new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    recreate();
                                }
                            });
                    snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
                    snackbar.show();
                } else if (error instanceof ParseError) {
                    Snackbar snackbar = Snackbar
                            .make(coordinatorLayout, "Data Error. Please try another time", Snackbar.LENGTH_INDEFINITE)
                            .setAction("Refresh", new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    recreate();
                                }
                            });
                    snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
                    snackbar.show();
                }


            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("_mId", _phoneNo);
                params.put("token", token);
                return params;
            }

        };
        eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        com.liteafrica.izigourmet.AppController.getInstance().addToRequestQueue(eventoReq);


    }

    private void erase() {
        pref.setGoTRide(0);
        pref.setUniqueRide(null);
        pref.packagesharedPreferences(null);
        pref.set_ride(0);
        pref.set_cID(0);
        pref.setPickAt1(null);
        pref.setDropAt1(null);
        pref.set_food_money(0);
        pref.set_food_items(0);
        pref.setPickLat1(null);
        pref.setPickLong1(null);
        pref.setCanteen(null);
        pref.setcName(null);
        pref.setcPhoto(null);
        pref.setcAddress(null);
        pref.setcDiscount(0);
        pref.setcPackaging(0);
        pref.setcLess(null);
        pref.setcMore(null);
        pref.setDelivery(0);
        pref.setGoTRide(0);
        pref.setTotal(null);
        pref.setTotal2(null);
        pref.setadTetxt(null);
        pref.setPayment(0);
    }

    private void go_trough() {
        if (_got) {
            if (_imp_1 != imp) {
                if (!Splash_screen.this.isFinishing()) {
                    new AlertDialog.Builder(Splash_screen.this, R.style.AlertDialogTheme)
                            .setIcon(R.mipmap.ic_launcher)
                            .setTitle("Update MeatExpress")
                            .setMessage("A new version of MeatExpress is available!")
                            .setPositiveButton("Update", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {
                                    String url = "https://play.google.com/store/apps/details?id=" + getPackageName();
                                    Intent i = new Intent(Intent.ACTION_VIEW);
                                    i.setData(Uri.parse(url));
                                    startActivity(i);
                                    dialog.cancel();
                                }
                            })
                            .show();
                }
            } else {

                if (version_1 != version_) {
                    if (!Splash_screen.this.isFinishing()) {
                        new AlertDialog.Builder(Splash_screen.this, R.style.AlertDialogTheme)
                                .setTitle("Its time to update MeatExpress")
                                .setMessage("A new version of MeatExpress is available!")
                                .setPositiveButton("Update", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        String url = "https://play.google.com/store/apps/details?id=" + getPackageName();
                                        Intent i = new Intent(Intent.ACTION_VIEW);
                                        i.setData(Uri.parse(url));
                                        startActivity(i);
                                        dialog.cancel();
                                    }
                                })
                                .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {

                                        launchHomeScreen();

                                        dialog.cancel();
                                    }
                                })
                                .show();
                    }
                } else {
                    go_again();
                }
            }

        } else {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Server Error. Please try another time", Snackbar.LENGTH_INDEFINITE)
                    .setAction("Refresh", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            recreate();
                        }
                    });
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();
        }
    }

    private void go_again() {
        stopLocationUpdates();

        if (User_image != null && !TextUtils.isEmpty(User_image)) {
            pref.setProfile(User_image);
            pref.setReview((float) User_review);
        }


        if (User_name != null && !TextUtils.isEmpty(User_name)) {
            pref.setName(User_name);
        }


        if (pref.getUniqueRide() != null) {
            String[] pars = pref.getUniqueRide().split("\\.");
            String con = TextUtils.join("", pars);
            if (pref.get_packagesharedPreferences() == null) {
                mDatabase.child("IziGourmet").child(con).addValueEventListener(new FirebaseDataListener_after_ride());
            } else {
                Intent i = new Intent(Splash_screen.this, Canteen_Mainactivity.class);
                startActivity(i);
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                finish();
            }

        } else {
            if (pref.getResposibility() == 2) {
                Intent i = new Intent(Splash_screen.this, DrivermapApp.class);
                startActivity(i);
                finish();

            } else if (pref.getResposibility() == 3) {
                Intent i = new Intent(Splash_screen.this, Tabs_past_future_ride.class);
                startActivity(i);
                finish();

            } else {
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                Intent i = new Intent(Splash_screen.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            }

        }


    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        finish();

    }

    public static class ErrorDialogFragment extends DialogFragment {
        public ErrorDialogFragment() {
        }

        @Override
        public Dialog onCreateDialog(Bundle savedInstanceState) {
            // Get the error code and retrieve the appropriate dialog
            int errorCode = this.getArguments().getInt(DIALOG_ERROR);
            return GoogleApiAvailability.getInstance().getErrorDialog(
                    this.getActivity(), errorCode, REQUEST_RESOLVE_ERROR);
        }

        @Override
        public void onDismiss(DialogInterface dialog) {
            dialog.cancel();
        }
    }

    public class MyCountDownTimer extends CountDownTimer {


        public MyCountDownTimer(long millisInFuture, long countDownInterval) {
            super(millisInFuture, countDownInterval);
        }


        @Override
        public void onTick(long millisUntilFinished) {

        }

        @Override
        public void onFinish() {
            go_trough();
        }
    }


    private class FirebaseDataListener_after_ride implements ValueEventListener {
        private String Cost;
        private String _paid;

        @Override
        public void onDataChange(DataSnapshot dataSnapshot) {
            _paid = (String) dataSnapshot.child("USERDONE").getValue();
            Cost = (String) dataSnapshot.child("COST").getValue();
            if (_paid != null) {
                if (!_paid.contains("DONE")) {
                    if (pref.getResposibility() == 1) {
                        Intent i = new Intent(Splash_screen.this, UserSuccess.class);
                        i.putExtra("COST", Cost);
                        i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                        i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        i.addFlags(Intent.FLAG_ACTIVITY_NO_ANIMATION);
                        startActivity(i);
                        finish();
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                    } else if (pref.getResposibility() == 2) {
                        Intent i = new Intent(Splash_screen.this, Success.class);
                        i.putExtra("COST", Cost);
                        i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                        i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        i.addFlags(Intent.FLAG_ACTIVITY_NO_ANIMATION);
                        startActivity(i);
                        finish();
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                    }
                }
            } else {
                if (!_second) {
                    _second = true;
                    ArrayList<String> _foods1 = new ArrayList<String>();
                    String _foods = (String) dataSnapshot.child("Order").getValue();
                    String[] pars = _foods.split("\\,");
                    if (pref.get_packagesharedPreferences() == null) {
                        _foods1.clear();
                        for (int i = 0; i < pars.length; i++) {
                            _foods1.add(pars[i]);
                        }
                        pref.packagesharedPreferences(_foods1);
                    }
                    pref.set_food_items(pars.length);
                    if (dataSnapshot.child("Payment").getValue() != null) {
                        String _payment = (String) dataSnapshot.child("Payment").getValue();
                        pref.setPayment(Integer.parseInt(_payment));
                    }
                    Intent i = new Intent(Splash_screen.this, GooglemapApp.class);
                    pref.set_ride(1);
                    startActivity(i);
                    overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                }
            }
        }

        @Override
        public void onCancelled(DatabaseError databaseError) {

        }
    }


}




