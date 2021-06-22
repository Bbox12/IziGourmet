package com.liteafrica.izigourmet.Activites.Main_Page;

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
import android.os.Bundle;
import android.os.Looper;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.animation.Animation;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.core.app.ActivityCompat;
import androidx.fragment.app.DialogFragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

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
import com.facebook.shimmer.ShimmerFrameLayout;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GoogleApiAvailability;
import com.google.android.gms.common.api.ApiException;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.ResolvableApiException;
import com.google.android.gms.common.api.Status;
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
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.android.libraries.places.api.model.Place;
import com.google.android.libraries.places.widget.Autocomplete;
import com.google.android.libraries.places.widget.AutocompleteActivity;
import com.google.android.libraries.places.widget.model.AutocompleteActivityMode;
import com.google.android.material.snackbar.Snackbar;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Adapters.CanteenAdapter;
import com.liteafrica.izigourmet.Model.Canteens;
import com.liteafrica.izigourmet.PrefManager;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class MapActivity extends AppCompatActivity implements
         GoogleApiClient.ConnectionCallbacks,
        GoogleApiClient.OnConnectionFailedListener,
        View.OnClickListener, Animation.AnimationListener {
    private static final String TAG = MapActivity.class.getSimpleName();
    private static final int REQUEST_RESOLVE_ERROR = 1001;
    // Unique tag for the error dialog fragment
    private static final String DIALOG_ERROR = "dialog_error";
    private static final int REQUEST_PERMISSIONS_REQUEST_CODE = 34;
    private static final int REQUEST_CHECK_SETTINGS = 0x1;
    private static final LatLngBounds BOUNDS_MOUNTAIN_VIEW = new LatLngBounds(
            new LatLng(25.00000, 91.00000), new LatLng(27.99999, 91.99999));
    private static final float POLYLINE_WIDTH = 8;
    private static final int REQUEST_PICK_FROM = 10016;
    private RecyclerView _moreRv;
    private final int REQUEST_LOCATION = 200;
    double My_lat, My_long;
    DecimalFormat dft = new DecimalFormat("0.00");
    DecimalFormat dfto = new DecimalFormat("0.000000");
    private GoogleApiClient mGoogleApiClient;
    private CoordinatorLayout coordinatorLayout;
    private PendingResult<LocationSettingsResult> result;
    private LocationSettingsRequest.Builder builder;
    private boolean mResolvingError = false;
    private String strAdd;
    private FusedLocationProviderClient mFusedLocationClient;
    private LocationRequest mLocationRequest;
    private LocationCallback mLocationCallback;
    private Location mCurrentLocation;
    private Boolean mRequestingLocationUpdates;
    private ImageView myLocationButton;
    private PrefManager pref;
    private String ID;
    private Toolbar toolbar;
    private boolean first;
    private Marker[] markers = new Marker[2000];
    private boolean drag;
    private TextView T1;
    private ImageView splash;
    private TextView myaddress,change,showmap;
    private RecyclerView _rvBranches;
    private ArrayList<Canteens> mCanteens = new ArrayList<Canteens>();
    private AutoCompleteTextView del_address;
    private LinearLayout newaddress;
    private Boolean _change=false;
    private EditText place_work1,place_other1,place_zip;
    private Button _cancel_book,_confirm_book;
    private ShimmerFrameLayout mShimmerViewContainer;
    private LinearLayout L22;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        pref = new PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        ID = user.get(PrefManager.KEY_MOBILE);
        setContentView(R.layout.bookingaddress);

        L22=findViewById(R.id.L22);

        mShimmerViewContainer = findViewById(R.id.shimmer_view_container);
        mShimmerViewContainer.setVisibility(View.VISIBLE);
        mShimmerViewContainer.startShimmerAnimation();

        place_other1= findViewById(R.id.place_other1);
        place_work1= findViewById(R.id.place_work1);
        place_zip= findViewById(R.id.place_zip);

        _rvBranches= findViewById(R.id.imageRV);
        _rvBranches.setNestedScrollingEnabled(false);

        coordinatorLayout=findViewById(R.id.cor_home_main);
        myaddress=findViewById(R.id.myaddress);

        del_address=findViewById(R.id.del_address);
        del_address.setOnClickListener(this::onClick);
        change=findViewById(R.id.change);
        change.setOnClickListener(this::onClick);
        newaddress=findViewById(R.id.newaddress);
        newaddress.setVisibility(View.GONE);

        _cancel_book=findViewById(R.id._cancel_book);
        _cancel_book.setOnClickListener(this::onClick);

        _confirm_book=findViewById(R.id._confirm_book);
        _confirm_book.setOnClickListener(this::onClick);

        if (!com.google.android.libraries.places.api.Places.isInitialized()) {
            com.google.android.libraries.places.api.Places.initialize(getApplicationContext(), com.liteafrica.izigourmet.Config_URL.APIKEY);
        }


          mRequestingLocationUpdates = false;
          mFusedLocationClient = LocationServices.getFusedLocationProviderClient(MapActivity.this);


        T1=findViewById(R.id.T1);

        showmap=findViewById(R.id.showmap);
        showmap.setOnClickListener(this::onClick);



        createLocationCallback();
        buildLocationSettingsRequest();
        rebuildGoogleApiClient();
        if (mGoogleApiClient != null && mGoogleApiClient.isConnected()) {
            onConnected(null);
        }





        toolbar = findViewById(R.id.toolbar_main);
        setSupportActionBar(toolbar);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(true);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent op = new Intent(MapActivity.this, Canteen_Mainactivity.class);
                op.putExtra("from", 1);
                startActivity(op);
                finish();

            }
        });
    }



    private void getEats() {


        ArrayList<Canteens> mCanteens1 = new ArrayList<Canteens>();

        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_MENU,
                new Response.Listener<String>() {
                    private double d2;

                    @Override
                    public void onResponse(String response) {

                        Log.w("volley", response);
                            mCanteens.clear();

                        try {
                            JSONObject jsonObj = new JSONObject(response);
                            JSONArray canteens = jsonObj.getJSONArray("canteens");
                            if (canteens.length() != 0) {
                                for (int i = 0; i < canteens.length(); i++) {
                                    JSONObject c = canteens.getJSONObject(i);
                                    if (!c.isNull("Name")) {
                                        Canteens item = new Canteens();
                                        item.setID(c.getInt("ID"));
                                        item.setName(c.getString("Name"));
                                        item.setAddress(c.getString("Address"));
                                        item.setLatitude(c.getDouble("Latitude"));
                                        item.setLongitude(c.getDouble("Longitude"));
                                        item.setDistance(c.getDouble("Distance"));
                                        mCanteens.add(item);
                                    }

                                }
                            }

                                        for(int i=0;i<mCanteens.size();i++){
                                            if(i>0) {
                                                double d1 = distance(My_lat, My_long, mCanteens.get(i).getLatitude(i), mCanteens.get(i).getLongitude(i));
                                                double d2 = distance(My_lat, My_long, mCanteens.get(i-1).getLatitude(i-1), mCanteens.get(i-1).getLongitude(i-1));
                                                if (d2 < d1) {
                                                 mCanteens1.add(mCanteens.get(i-1));
                                                    mCanteens1.add(mCanteens.get(i));
                                                } else {
                                                    mCanteens1.add(mCanteens.get(i));
                                                    mCanteens1.add(mCanteens.get(i-1));
                                                }
                                            }
                                        }

                        } catch (final JSONException e) {
                            Log.e("HI", "Json parsing error: " + e.getMessage());


                        }
                        if (mCanteens.size() > 0) {
                            CanteenAdapter sAdapter1 = new CanteenAdapter(MapActivity.this, mCanteens1);
                            sAdapter1.notifyDataSetChanged();
                            sAdapter1.setPref(pref);
                            sAdapter1.setLocation(new LatLng(My_lat,My_long));
                            _rvBranches.setAdapter(sAdapter1);
                            LinearLayoutManager mLayoutManager = new LinearLayoutManager(MapActivity.this, LinearLayoutManager.VERTICAL, false);
                            _rvBranches.setLayoutManager(mLayoutManager);
                            _rvBranches.smoothScrollToPosition(sAdapter1.getItemCount());
                            _rvBranches.setHasFixedSize(true);
                            mShimmerViewContainer.stopShimmerAnimation();
                            mShimmerViewContainer.setVisibility(View.GONE);
                            L22.setVisibility(View.VISIBLE);
                        }

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLogerr(error);


            }

        }) {


            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("_mId", "_phoneNo");
                return params;
            }

        };
        eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        com.liteafrica.izigourmet.AppController.getInstance().addToRequestQueue(eventoReq);

    }

    private double distance(double lat1, double lon1, double lat2, double lon2) {
        double theta = lon1 - lon2;
        double dist = Math.sin(deg2rad(lat1))
                * Math.sin(deg2rad(lat2))
                + Math.cos(deg2rad(lat1))
                * Math.cos(deg2rad(lat2))
                * Math.cos(deg2rad(theta));
        dist = Math.acos(dist);
        dist = rad2deg(dist);
        dist = dist * 60 * 1.1515;
        return (dist);
    }

    private double deg2rad(double deg) {
        return (deg * Math.PI / 180.0);
    }

    private double rad2deg(double rad) {
        return (rad * 180.0 / Math.PI);
    }


    private void VolleyLogerr(VolleyError error) {
        if (error instanceof TimeoutError || error instanceof NoConnectionError) {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_LONG)
                    .setAction("Refresh", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            finish();
                            overridePendingTransition(0, 0);
                            startActivity(getIntent());
                        }
                    });
            snackbar.setActionTextColor(Color.RED);
            snackbar.setTextColor(Color.WHITE);
            snackbar.show();
        } else if (error instanceof AuthFailureError) {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_LONG)
                    .setAction("Refresh", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            finish();
                            overridePendingTransition(0, 0);
                            startActivity(getIntent());
                        }
                    });
            snackbar.setActionTextColor(Color.RED);
            snackbar.setTextColor(Color.WHITE);
            snackbar.show();
        } else if (error instanceof ServerError) {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Server Error.Please try another time", Snackbar.LENGTH_LONG)
                    .setAction("Refresh", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            finish();
                            overridePendingTransition(0, 0);
                            startActivity(getIntent());
                        }
                    });
            snackbar.setActionTextColor(Color.RED);
            snackbar.setTextColor(Color.WHITE);
            snackbar.show();
        } else if (error instanceof NetworkError) {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network Error. Please try another time", Snackbar.LENGTH_LONG)
                    .setAction("Refresh", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            finish();
                            overridePendingTransition(0, 0);
                            startActivity(getIntent());
                        }
                    });
            snackbar.setActionTextColor(Color.RED);
            snackbar.setTextColor(Color.WHITE);
            snackbar.show();
        } else if (error instanceof ParseError) {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Data Error. Please try another time", Snackbar.LENGTH_LONG)
                    .setAction("Refresh", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            finish();
                            overridePendingTransition(0, 0);
                            startActivity(getIntent());
                        }
                    });
            snackbar.setActionTextColor(Color.RED);
            snackbar.setTextColor(Color.WHITE);
            snackbar.show();
        }

    }



    @Override
    protected void onResume() {
        super.onResume();


    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == REQUEST_PICK_FROM) {
            if (resultCode == RESULT_OK) {

                Place place = Autocomplete.getPlaceFromIntent(data);

                if (!TextUtils.isEmpty(place.getAddress())) {
                    del_address.setText(place.getAddress());
                    LatLng queriedLocation = place.getLatLng();
                    if (queriedLocation != null) {
                        My_lat = queriedLocation.latitude;
                        My_long = queriedLocation.longitude;
                        pref.setDropLat(String.valueOf(My_lat));
                        pref.setDropLong(String.valueOf(My_long));
                    }

                    pref.setDropAt(del_address.getText().toString());
                 //  getCompleteAddressString(My_lat, My_long);
                    getEats();
                }
                Log.e("TAG", "Place: " + pref.getDropAt());
            } else if (resultCode == AutocompleteActivity.RESULT_ERROR) {
                // TODO: Handle the error.
                Status status = Autocomplete.getStatusFromIntent(data);
                Log.e("TAG", "Place: " + status);
            }  // The user canceled the operation.

        }
    }

    private void go(String s1, String s2, String s3, String s4) {
        if (s3 == null) {
            s3 = "";
        }
        pref.setDropAt("House No: " + s2 + "| " + s1 + "| " + "| " + s3 + "| " + s4);
    //    _address = "House No: " + s2 + "| " + s1 + "| " + "| " + s3 + "| " + s4;
     //   upload();
    }

    @Override
    public void onClick(View v) {

        switch (v.getId()){

            case R.id._cancel_book:
                pref.setDelivery(0);
                pref.setDropAt1(null);
                pref.setPickAt1(null);
                pref.setPickLat1(null);
                pref.setPickLong1(null);
                pref.set_cID(0);
                pref.set_food_money(0);
                pref.set_food_items(0);
                pref.setPayment(0);
                pref.packagesharedPreferences(null);
                pref.setUniqueRide(null);
                pref.setCon(null);
                pref.setTotal(null);
                pref.setTotal2(null);
                Intent oq = new Intent(MapActivity.this, Canteen_Mainactivity.class);
                startActivity(oq);
                finish();
                break;

            case R.id._confirm_book:
                if(_change){
                    if (TextUtils.isEmpty(del_address.getText().toString())) {
                        del_address.setError("Address Missing");
                    } else {
                        if (TextUtils.isEmpty(place_work1.getText().toString())) {
                            place_work1.setError("Please input House.Flat No");
                        } else {
                            if (TextUtils.isEmpty(place_zip.getText().toString())) {
                                place_zip.setError("Please input zip code");
                            } else {
                                strAdd = "Address "+del_address.getText().toString()+"\nHouse No: " + place_work1.getText().toString() + "| " + place_other1.getText().toString() + "| " + "\nZip code " + place_zip.getText().toString();

                            }
                        }

                    }
                   }else{
                    strAdd = "Address "+myaddress.getText().toString();
                    pref.setDropLat(String.valueOf(My_lat));
                    pref.setDropLong(String.valueOf(My_long));
                }
                pref.setDropAt(strAdd);
                Intent op = new Intent(MapActivity.this, PaymentWindow.class);
                startActivity(op);
                finish();
                break;


            case R.id.showmap:
                Intent o = new Intent(MapActivity.this, ShowMap.class);
                startActivity(o);
                finish();
                break;


            case R.id.change:
                if(!_change) {
                    _change=true;
                    change.setText("Hide");
                    newaddress.setVisibility(View.VISIBLE);
                }else{
                    _change=false;
                    change.setText("Change");
                    newaddress.setVisibility(View.GONE);
                }
                break;

            case R.id.del_address:
                List<Place.Field> placeFields = Arrays.asList(Place.Field.ID, Place.Field.NAME, Place.Field.ADDRESS
                        , Place.Field.LAT_LNG);
                Intent intent = new Autocomplete.IntentBuilder(
                        AutocompleteActivityMode.OVERLAY, placeFields)
                        .build(this);
                startActivityForResult(intent, REQUEST_PICK_FROM);

                break;



        }

    }


    protected LocationRequest createLocationRequest() {
        mLocationRequest = new LocationRequest();
        mLocationRequest.setInterval(180000);
        mLocationRequest.setFastestInterval(180000);
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
                .enableAutoManage(this,0,this )
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
    public void onAnimationStart(Animation animation) {

    }

    @Override
    public void onAnimationEnd(Animation animation) {

    }

    @Override
    public void onAnimationRepeat(Animation animation) {

    }

    @Override
    public void onConnected(@Nullable Bundle bundle) {
        builder = new LocationSettingsRequest.Builder().addLocationRequest(createLocationRequest());
        Task<LocationSettingsResponse> task = LocationServices.getSettingsClient(this).checkLocationSettings(builder.build());
        task.addOnCompleteListener(new OnCompleteListener<LocationSettingsResponse>() {
            @Override
            public void onComplete(@NonNull Task<LocationSettingsResponse> task) {
                try {
                    LocationSettingsResponse response = task.getResult(ApiException.class);
                    startLocationUpdat();
                } catch (ApiException exception) {
                    switch (exception.getStatusCode()) {
                        case LocationSettingsStatusCodes.RESOLUTION_REQUIRED:
                            try {
                                ResolvableApiException resolvable = (ResolvableApiException) exception;
                                resolvable.startResolutionForResult(MapActivity.this, REQUEST_CHECK_SETTINGS);
                                break;
                            } catch (IntentSender.SendIntentException e) {
                            } catch (ClassCastException e) {
                                Log.w(" ClassCastException", "Canont get Address!"+e.getLocalizedMessage());
                            }
                            break;
                        case LocationSettingsStatusCodes.SETTINGS_CHANGE_UNAVAILABLE:
                            break;
                    }
                }}
        });
    }

    @Override
    public void onConnectionSuspended(int i) {
        googleApiClientConnectionStateChange(false);
        mGoogleApiClient.connect();
    }

    @Override
    public void onConnectionFailed(@NonNull ConnectionResult result) {
        if (mResolvingError) {

        } else if (result.hasResolution()) {
            try {
                mResolvingError = true;
                result.startResolutionForResult(this, REQUEST_RESOLVE_ERROR);
            } catch (IntentSender.SendIntentException e) {
                mGoogleApiClient.connect();
            }
        } else {
            // showErrorDialog(result.getErrorCode());
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

    private void updateLocationUI(Location location) {

        My_lat = location.getLatitude();
        My_long = location.getLongitude();

        if(!first ) {
            first=true;
            myaddress.setText(getCompleteAddressString(My_lat,My_long));
            getEats();

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





    private void startLocationUpdat() {
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            return;
        }
        if(mFusedLocationClient!=null ) {
            mFusedLocationClient.requestLocationUpdates(createLocationRequest(), new LocationCallback() {
                        @Override
                        public void onLocationResult(LocationResult locationResult) {

                            List<Location> locationList = locationResult.getLocations();
                            if (locationList.size() > 0) {
                                Location location = locationList.get(locationList.size() - 1);
                                Log.i("MapsActivity", "Location: " + String.valueOf(location));
                                updateLocationUI(location);
                            }

                        }
                    },
                    Looper.myLooper());
        }
    }


    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_refresh, menu);
        return true;

    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        return super.onOptionsItemSelected(item);
    }


    @Override
    protected void onStop() {
        super.onStop();
        mShimmerViewContainer.stopShimmerAnimation();

        stopLocationUpdates();
    }

    @Override
    protected void onPause() {
        super.onPause();
        mShimmerViewContainer.stopShimmerAnimation();
        stopLocationUpdates();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        mShimmerViewContainer.stopShimmerAnimation();
        stopLocationUpdates();
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event)
    {
        //replaces the default 'Back' button action
        if(keyCode== KeyEvent.KEYCODE_BACK)   {

            Intent o = new Intent(MapActivity.this, Canteen_Mainactivity.class);
            o.putExtra("from",1);
            startActivity(o);
            finish();


        }
        return true;
    }

}
