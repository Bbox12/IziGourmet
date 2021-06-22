package com.liteafrica.izigourmet.Requests;

import android.app.Activity;
import android.app.Dialog;
import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.TimePicker;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkError;
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.liteafrica.izigourmet.Activites.Success;
import com.liteafrica.izigourmet.Adapters.BookingAdapter;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.Model.Foods;
import com.liteafrica.izigourmet.Model.User;
import com.liteafrica.izigourmet.Model.driver;
import com.liteafrica.izigourmet.R;
import com.squareup.picasso.Picasso;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;
import java.util.TimeZone;

public class OrderDashboard extends AppCompatActivity implements View.OnClickListener {
    private static final String TAG = OrderDashboard.class.getSimpleName();
    SimpleDateFormat simpleDateFormat =
            new SimpleDateFormat("yyy-MM-dd");
    private ImageView Snapshot, PastDriver, PastCar;
    private EditText past_name_driver, Past_car, past_booking_time, past_start_time, past_delivery_time;
    private Toolbar toolbar;
    private double My_lat = 0, My_long = 0;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _PhoneNo;
    private ProgressBar progressBar;
    private String UNIQUEID;
    private TextView Tool1, Tool2;
    private LinearLayout C_applied;
    private DatabaseReference mDatabase;
    private EditText Past_total_Km;
    private TextView From_address, To_address;
    private TextView _tAmount, _dAmount, _pAmount, _delAmount, _payAmount, _cAmount, dst;
    private TextView _moneyValue, _itemValue, _discount, delivery;
    private RecyclerView _moreRv;
    private CoordinatorLayout coordinatorLayout;
    private SwipeRefreshLayout mSwipeRefreshLayout;
    private TextView ETR;
    private TextView orders, pending, deliveredto, address;
    private ImageView _i4;
    private TextView y5;
    private LinearLayout _L1, L5, L6;
    private boolean drawn1 = false;
    private boolean drawn2 = false;
    private boolean drawn3 = false;
    private boolean drawn4 = false;
    private boolean drawn5 = false;
    private boolean get1 = false;
    private boolean get2 = false;
    private boolean get3 = false;
    private boolean get4 = false;
    private boolean get5 = false;
    private RadioButton orderaccepted, ontheway, comming, confirmorder, Order_in_Progress;
    private EditText description;
    private Button _upload, _cancel;
    private int _accepet = 0;
    private FirebaseDataListener_after_ride _firebaseLogs;
    private String UniqueCode;
    private EditText _dateSubmit, _timeSubmit;
    private AutoCompleteTextView driver, vehicle;
    private String _driverID, _vehicleID;
    private EditText damt;
    private String _mobile = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.new_rides);
        _moreRv = findViewById(R.id.moreRvs);
        _moreRv.setNestedScrollingEnabled(false);
        _moneyValue = findViewById(R.id.canteen_amounts);
        _itemValue = findViewById(R.id._noofItemss);
        _discount = findViewById(R.id.discounts);
        _tAmount = findViewById(R.id._tamounts);
        _dAmount = findViewById(R.id._damounts);
        _cAmount = findViewById(R.id._camounts);
        _delAmount = findViewById(R.id._delamounts);
        _payAmount = findViewById(R.id._payamounts);
        pending = findViewById(R.id.pending);
        toolbar = findViewById(R.id.toolbardd);
        deliveredto = findViewById(R.id.deliveredto);
        address = findViewById(R.id.address);
        ETR = findViewById(R.id.ETR);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        PastDriver = findViewById(R.id.past_driver);
        Past_car = findViewById(R.id.past_car_detail);
        past_booking_time = findViewById(R.id.past_booking_time);
        past_delivery_time = findViewById(R.id.past_total_delivery_time);
        progressBar = findViewById(R.id.progressBarpast);
        Tool1 = findViewById(R.id.past101);
        Tool2 = findViewById(R.id.past102);
        Tool1.setText("Order on ");
        delivery = findViewById(R.id.pmode);
        coordinatorLayout = findViewById(R.id.cor_home_eats);
        past_name_driver = findViewById(R.id.past_name_driver);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        L5 = findViewById(R.id.L5);
        L5.setVisibility(View.VISIBLE);
        description = findViewById(R.id.description);
        _upload = findViewById(R.id.btnUpload);
        _upload.setOnClickListener(this);
        _cancel = findViewById(R.id.btnCancel);
        _cancel.setOnClickListener(this);

        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(OrderDashboard.this, Tabs_past_future_ride.class);
                startActivity(i);
                finish();
            }
        });
        orders = findViewById(R.id.orders);
        _L1 = findViewById(R.id._L1);
        if (pref.get_food_items() != 0) {
            orders.setText(String.valueOf(pref.get_food_items()));

        }
        dst = findViewById(R.id.dst);
        mSwipeRefreshLayout = findViewById(R.id.swipeToRefresh);
        mSwipeRefreshLayout.setColorSchemeResources(R.color.colorAccent);
        mSwipeRefreshLayout.setRefreshing(true);


        y5 = findViewById(R.id.y5);
        y5.setOnClickListener(this);

        orderaccepted = findViewById(R.id.orderaccepted);
        ontheway = findViewById(R.id.ontheway);
        comming = findViewById(R.id.comming);
        confirmorder = findViewById(R.id.confirmorder);
        Order_in_Progress = findViewById(R.id.Order_in_Progress);

        _firebaseLogs = new FirebaseDataListener_after_ride();
        _timeSubmit = findViewById(R.id._time_submit);
        _timeSubmit.setOnClickListener(this);
        _dateSubmit = findViewById(R.id._date_submit);
        _dateSubmit.setOnClickListener(this);
        driver = findViewById(R.id.driver);
        driver.setOnClickListener(this);
        vehicle = findViewById(R.id.vehicle);
        vehicle.setOnClickListener(this);
        damt = findViewById(R.id.damt);
        L6 = findViewById(R.id.L6);
    }

    @Override
    protected void onResume() {
        super.onResume();
        Intent i = getIntent();
        UNIQUEID = i.getStringExtra("unique");
        mDatabase = FirebaseDatabase.getInstance().getReference();
        progressBar.setVisibility(View.VISIBLE);
        mSwipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                recreate();
                mSwipeRefreshLayout.setRefreshing(true);
            }
        });

        final ArrayList<Foods> mUser = new ArrayList<Foods>();
        final ArrayList<User> mItems = new ArrayList<User>();
        final ArrayList<driver> mDriver = new ArrayList<driver>();
        final ArrayList<driver> mVehicle = new ArrayList<driver>();
        final ArrayList<String> mDriver1 = new ArrayList<String>();
        final ArrayList<String> mVehicle1 = new ArrayList<String>();
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_ORDERS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        Log.e("submenu", response);
                        try {

                            JSONObject jsonObj = new JSONObject(response);
                            JSONArray Eat = jsonObj.getJSONArray("bookings");
                            if (Eat.length() != 0) {
                                for (int i = 0; i < Eat.length(); i++) {
                                    JSONObject c = Eat.getJSONObject(i);
                                    if (!c.isNull("Price")) {
                                        Foods items = new Foods();
                                        items.setID(c.getInt("ID"));
                                        items.setNoofItems(c.getInt("NoofItems"));
                                        items.seteTEZ_Price((c.getInt("NoofItems") * c.getDouble("Price")) - (c.getInt("NoofItems") * c.getDouble("Discount")));
                                        items.setDiscount(c.getDouble("Discount"));
                                        items.setMenu_Name(c.getString("Name"));
                                        mUser.add(items);
                                    }
                                }

                            }

                            JSONArray timings = jsonObj.getJSONArray("timings");
                            if (timings.length() != 0) {
                                for (int i = 0; i < timings.length(); i++) {
                                    JSONObject c = timings.getJSONObject(i);
                                    if (!c.isNull("Delivered")) {
                                        User items = new User();
                                        UniqueCode = c.getString("Unique_Ride_Code");
                                        items.setStart_time(c.getString("Booking_Date") + " " + c.getString("Booking_Time"));
                                        items.setEnd_time(c.getString("End_Date") + " " + c.getString("End_Time"));
                                        items.setDrivername(c.getString("Driver"));
                                        items.setVehicle(c.getString("Vehicle_ID"));
                                        items.setDriverImage(c.getString("Photo"));
                                        items.setDelivered(c.getInt("Delivered"));
                                        items.setCost(c.getString("Cost"));
                                        items.setTime(c.getString("ETR"));
                                        items.setpCost(c.getString("pCost"));
                                        items.setPaymentVerified(c.getInt("PaymentVerified"));
                                        items.setPaymentMode(c.getInt("PaymentMode"));
                                        items.setIs_Paid(c.getInt("Is_Paid"));
                                        items.setAddress(c.getString("From_Address"));
                                        mItems.add(items);
                                    }
                                }

                            }

                            JSONArray driver = jsonObj.getJSONArray("drivers");
                            if (driver.length() != 0) {
                                for (int i = 0; i < driver.length(); i++) {
                                    JSONObject c = driver.getJSONObject(i);
                                    if (!c.isNull("ID")) {
                                        com.liteafrica.izigourmet.Model.driver items = new driver();
                                        items.setID(c.getInt("ID"));
                                        items.setName(c.getString("Name"));
                                        items.setPhoneNo(c.getString("Phone_No"));
                                        mDriver.add(items);
                                        mDriver1.add(c.getString("Name"));
                                    }
                                }

                            }
                            JSONArray vehicle = jsonObj.getJSONArray("vehicle");
                            if (vehicle.length() != 0) {
                                for (int i = 0; i < vehicle.length(); i++) {
                                    JSONObject c = vehicle.getJSONObject(i);
                                    if (!c.isNull("ID")) {
                                        com.liteafrica.izigourmet.Model.driver items = new driver();
                                        items.setID(c.getInt("ID"));
                                        items.setName(c.getString("Name"));
                                        mVehicle.add(items);
                                        mVehicle1.add(c.getString("Name"));
                                    }
                                }

                            }

                            mSwipeRefreshLayout.setRefreshing(false);
                            go(mItems);

                        } catch (final JSONException e) {
                            Log.e("HI", "Json parsing error: " + e.getMessage());


                        }


                        BookingAdapter sAdapter1 = new BookingAdapter(OrderDashboard.this, mUser);
                        sAdapter1.notifyDataSetChanged();
                        sAdapter1.setPref(pref);
                        sAdapter1.setFrom(1);
                        LinearLayoutManager mLayoutManager = new LinearLayoutManager(OrderDashboard.this, LinearLayoutManager.VERTICAL, false);
                        _moreRv.setLayoutManager(mLayoutManager);
                        _moreRv.setItemAnimator(new DefaultItemAnimator());
                        _moreRv.setAdapter(sAdapter1);
                        _moreRv.setHasFixedSize(true);

                        final ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(
                                getBaseContext(), android.R.layout.simple_list_item_1, mDriver1);
                        final String[] selection1 = new String[1];
                        driver.setAdapter(arrayAdapter);
                        driver.setCursorVisible(false);
                        driver.setOnItemClickListener(new AdapterView.OnItemClickListener() {

                            @Override
                            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                                selection1[0] = (String) parent.getItemAtPosition(position);
                                for (int i = 0; i < mDriver.size(); i++) {
                                    if (mDriver.get(i).getName(i).contains(selection1[0])) {
                                        _driverID = mDriver.get(i).getName(i);
                                        _mobile = mDriver.get(i).getPhoneNo(i);
                                    }
                                }

                            }
                        });
                        final ArrayAdapter<String> arrayAdapter1 = new ArrayAdapter<String>(
                                getBaseContext(), android.R.layout.simple_list_item_1, mVehicle1);
                        final String[] selection2 = new String[1];
                        vehicle.setAdapter(arrayAdapter1);
                        vehicle.setCursorVisible(false);
                        vehicle.setOnItemClickListener(new AdapterView.OnItemClickListener() {

                            @Override
                            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                                selection2[0] = (String) parent.getItemAtPosition(position);
                                for (int i = 0; i < mVehicle.size(); i++) {
                                    if (mVehicle.get(i).getName(i).contains(selection2[0])) {
                                        _vehicleID = mDriver.get(i).getName(i);
                                    }
                                }

                            }
                        });


                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                vollyError(error);
            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("_mId", _PhoneNo);
                params.put("submenu", UNIQUEID);
                return params;
            }

        };

        AppController.getInstance().addToRequestQueue(eventoReq);
    }

    private void go(ArrayList<User> mItems) {
        progressBar.setVisibility(View.GONE);
        if (mItems.size() != 0) {


            if (mItems.get(0).getStart_time(0) != null &&
                    !TextUtils.isEmpty(mItems.get(0).getStart_time(0))) {
                String date_ = parseDateToddMMyyyy(mItems.get(0).getStart_time(0));
                Tool2.setText("Booking date " + date_);

            }

            address.setText(mItems.get(0).getAddress(0));

            if (mItems.get(0).getPaymentMode(0) == 1) {
                if (mItems.get(0).getIs_Paid(0) == 1) {
                    pending.setText(" COD, PAID");
                    y5.setVisibility(View.GONE);
                }
            } else if (mItems.get(0).getPaymentMode(0) == 2) {
                if (mItems.get(0).getPaymentVerified(0) == 0) {
                    pending.setText("EFT PAYMENT PENDING");
                } else {
                    pending.setText("EFT PAYMENT DONE");
                }
                y5.setVisibility(View.VISIBLE);
            }
            if (mItems.get(0).getPaymentMode(0) == 0) {

                pending.setText("PAYMENT NOT SELECTED");

            }

            if (mItems.get(0).getDriverImage(0) != null &&
                    !TextUtils.isEmpty(mItems.get(0).getDriverImage(0))) {

                Picasso.with(OrderDashboard.this)
                        .load(mItems.get(0).getDriverImage(0))
                        .resize(80, 80)
                        .centerCrop()
                        .into(PastDriver);

            }
            if (mItems.get(0).getVehicle(0) != null && !mItems.get(0).getVehicle(0).contains("null")) {
                Past_car.setText("Vehicle no :" + mItems.get(0).getVehicle(0));
            }
            DecimalFormat dft = new DecimalFormat("0.00");
            if (mItems.get(0).getCost(0) != null && !mItems.get(0).getCost(0).contains("null")) {
                _payAmount.setText("R" + mItems.get(0).getCost(0));
                if (Double.parseDouble(mItems.get(0).getpCost(0)) != 0) {
                    _tAmount.setText("R" + mItems.get(0).getpCost(0));
                    double d = Double.parseDouble(mItems.get(0).getpCost(0)) - Double.parseDouble(mItems.get(0).getCost(0));
                    _dAmount.setText("-" + dft.format(d));
                } else {
                    _tAmount.setText("R" + mItems.get(0).getCost(0));
                }
                _moneyValue.setVisibility(View.GONE);
                _itemValue.setVisibility(View.GONE);
                dst.setVisibility(View.GONE);
            }


            if (pref.getisDel() != 0) {
                _delAmount.setText(dft.format(pref.getDcharge()));
            } else {
                _delAmount.setText("TBC");
            }
            if (mItems.get(0).getDelivered(0) == 0) {
                delivery.setText("Order Pending");
                deliveredto.setText("Delivery address:");
            } else if (mItems.get(0).getDelivered(0) == 1) {
                delivery.setText("Order Accepted");
                deliveredto.setText("Delivery address:");
            }
            if (mItems.get(0).getDelivered(0) == 2) {
                delivery.setText("Order Confirmed");
                deliveredto.setText("Delivery address:");
            }
            if (mItems.get(0).getDelivered(0) == 3) {
                delivery.setText("Delivery date updated");
                deliveredto.setText("Delivery address:");
            }
            if (mItems.get(0).getDelivered(0) == 4) {
                delivery.setText("Order Dispatched");
                deliveredto.setText("Delivery address:");
            }
            if (mItems.get(0).getDelivered(0) == 5) {
                delivery.setText("Order Delivered");
                deliveredto.setText("Delivery address:");
            }
            if (mItems.get(0).getDelivered(0) == 6) {
                deliveredto.setVisibility(View.GONE);
                address.setVisibility(View.GONE);
                delivery.setText("Order Canceled");
            }


            if (mItems.get(0).getStart_time(0) != null &&
                    !TextUtils.isEmpty(mItems.get(0).getStart_time(0)) && !mItems.get(0).getStart_time(0).contains("null")) {
                String date_ = parseDateToAM(mItems.get(0).getStart_time(0));
                past_booking_time.setText(date_);
            }
            if (mItems.get(0).getEnd_time(0) != null &&
                    !TextUtils.isEmpty(mItems.get(0).getEnd_time(0)) && !mItems.get(0).getEnd_time(0).contains("null")) {
                String date_ = parseDateToAM(mItems.get(0).getEnd_time(0));
                past_delivery_time.setText(date_);
            }


            if (mItems.get(0).getTime(0) != null && !mItems.get(0).getTime(0).contains("null")) {
                ETR.setText(parseDateToETR(mItems.get(0).getTime(0)));
            }
            String[] pars = UniqueCode.split("\\.");
            String con = TextUtils.join("", pars);
            pref.setUniqueRide(UniqueCode);
            mDatabase.child("IziGourmet").child(con).addValueEventListener(_firebaseLogs);
        }
    }


    public String parseDateToddMMyyyy(String time) {
        String inputPattern = "yyyy-MM-dd";
        String outputPattern = "dd MMM yy";
        SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
        SimpleDateFormat outputFormat = new SimpleDateFormat(outputPattern);

        Date date = null;
        String str = null;

        try {
            date = inputFormat.parse(time);
            str = outputFormat.format(date);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        return str;
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();

        Intent o = new Intent(OrderDashboard.this, Tabs_past_future_ride.class);
        startActivity(o);
        finish();

    }

    public String parseDateToAM(String time) {
        String inputPattern = "yyyy-MM-ddHH:mm:ss";
        String outputPattern = "dd MMM yy hh:mm aa";
        SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
        SimpleDateFormat outputFormat = new SimpleDateFormat(outputPattern);

        Date date = null;
        String str = null;

        try {
            date = inputFormat.parse(time);
            str = outputFormat.format(date);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        return str;
    }

    public String parseDateToETR(String time) {
        String inputPattern = "MM-dd-yyyyhh:mm aa";
        String outputPattern = "dd MMM yy hh:mm aa";
        SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
        SimpleDateFormat outputFormat = new SimpleDateFormat(outputPattern);

        Date date = null;
        String str = null;

        try {
            date = inputFormat.parse(time);
            str = outputFormat.format(date);
        } catch (ParseException e) {
            //e.printStackTrace();
            String inputPattern1 = "MM-dd-yyyy";
            String outputPattern1 = "dd MMM yy";
            SimpleDateFormat inputFormat1 = new SimpleDateFormat(inputPattern1);
            SimpleDateFormat outputFormat1 = new SimpleDateFormat(outputPattern1);

            Date date1 = null;

            try {
                date1 = inputFormat1.parse(time);
                str = outputFormat1.format(date1);
            } catch (ParseException e1) {
                e1.printStackTrace();
            }
        }
        return str;
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {

            case R.id.driver:
                driver.showDropDown();
                break;
            case R.id.vehicle:
                vehicle.showDropDown();
                break;

            case R.id._date_submit:
                try {
                    open_date(_dateSubmit);
                } catch (ParseException e) {
                    e.printStackTrace();
                }

                break;

            case R.id._time_submit:
                if (!TextUtils.isEmpty(_dateSubmit.getText().toString())) {
                    open_time(_timeSubmit);
                } else {
                    _dateSubmit.setError("Select date");
                }
                break;

            case R.id.btnUpload:

                if (_accepet == 0) {
                    acceptOrder(description.getText().toString(), 1);
                } else if (_accepet == 1) {
                    acceptOrder(description.getText().toString(), 1);
                } else if (_accepet == 2) {
                    acceptOrder(description.getText().toString(), 2);
                } else if (_accepet == 3) {
                    if (!TextUtils.isEmpty(_dateSubmit.getText().toString())) {
                        if (!TextUtils.isEmpty(_timeSubmit.getText().toString())) {
                            if (!TextUtils.isEmpty(driver.getText().toString())) {
                                if (!TextUtils.isEmpty(vehicle.getText().toString())) {
                                    MeatAccept(_dateSubmit.getText().toString(), _timeSubmit.getText().toString());
                                } else {
                                    vehicle.showDropDown();
                                }
                            } else {
                                driver.showDropDown();
                            }
                        } else {
                            _timeSubmit.requestFocus();
                        }
                    } else {
                        _dateSubmit.requestFocus();
                    }
                } else if (_accepet == 4) {
                    myOntheway(description.getText().toString());
                } else if (_accepet == 5) {
                    myDelivered(description.getText().toString());
                }
                break;

            case R.id.btnCancel:
                if (!TextUtils.isEmpty(description.getText().toString())) {
                    rejectOrder(description.getText().toString());
                } else {
                    description.requestFocus();
                    description.setError("Empty");
                }

                break;


        }

    }


    private void vollyError(VolleyError error) {
        if (error instanceof TimeoutError || error instanceof NoConnectionError) {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_INDEFINITE)
                    .setAction("Refresh", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {

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

                        }
                    });
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();
        }
    }

    public void toggleBottomSheet() {
        if (get1 && !drawn1) {
            drawn1 = true;
            orderaccepted.setChecked(true);
            //  _searchText.setText("Your order has been accepted.");
            _accepet = 1;
            _upload.setText("Confirm Order");

        }

        if (get2 && !drawn2) {
            drawn2 = true;
            orderaccepted.setChecked(true);
            confirmorder.setChecked(true);
            // _searchText.setText("Your order has been confirmed.");
            _accepet = 2;
            L6.setVisibility(View.VISIBLE);
            _upload.setText("Update ETR");
        }

        if (get3 && !drawn3) {
            drawn2 = true;
            orderaccepted.setChecked(true);
            confirmorder.setChecked(true);
            Order_in_Progress.setChecked(true);
            //  _searchText.setText("Estimated delivery time updated.");
            _accepet = 3;
            L6.setVisibility(View.GONE);
            _cancel.setVisibility(View.GONE);
            _upload.setText("On the way");
            _cancel.setVisibility(View.GONE);
        }

        if (get4 && !drawn4) {
            drawn4 = true;
            ontheway.setChecked(true);
            comming.setChecked(false);
            orderaccepted.setChecked(true);
            confirmorder.setChecked(true);
            Order_in_Progress.setChecked(true);
            //  _searchText.setText("Your order has been dispatched!");
            _accepet = 4;
            L6.setVisibility(View.GONE);
            _cancel.setVisibility(View.GONE);
            _upload.setText("Delivered");
            _cancel.setVisibility(View.GONE);
        }


        if (get5 && !drawn5) {
            drawn5 = true;
            // _searchText.setText("Knock knock! Order is at doorstep.");
            comming.setChecked(true);
            ontheway.setChecked(true);
            orderaccepted.setChecked(true);
            confirmorder.setChecked(true);
            Order_in_Progress.setChecked(true);
            _accepet = 5;
            L6.setVisibility(View.VISIBLE);
            _cancel.setVisibility(View.GONE);
        }


    }

    private void myDelivered(String msg) {
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, "http://139.59.38.160/IziGourmet/Dashboard/OrderDeliveredApp.php?id=" + UNIQUEID,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {
                            String[] pars = UniqueCode.split("\\.");
                            String con = TextUtils.join("", pars);
                            mDatabase.child("IziGourmet").child(con).child("ask").setValue("6");
                            ViewDialogFailedSuccess alert = new ViewDialogFailedSuccess();
                            alert.showDialog(OrderDashboard.this, "Success!", false);

                        } else {
                            ViewDialogFailed alert = new ViewDialogFailed();
                            alert.showDialog(OrderDashboard.this, "Failed to store information!", true);
                        }


                    }


                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                vollyError(error);
            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                // Posting parameters to login url
                Map<String, String> params = new HashMap<String, String>();
                params.put("from", "1");
                return params;
            }

        };

        // Añade la peticion a la cola
        AppController.getInstance().addToRequestQueue(eventoReq);
    }

    private void myOntheway(String msg) {
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, "http://139.59.38.160/IziGourmet/Dashboard/OntheWayApp.php?id=" + UNIQUEID + "&reason=" + msg,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {
                            String[] pars = UniqueCode.split("\\.");
                            String con = TextUtils.join("", pars);
                            mDatabase.child("IziGourmet").child(con).child("ask").setValue("5");
                            mDatabase.child("IziGourmet").child(con).child("message").setValue(description.getText().toString());
                            ViewDialogFailedSuccess alert = new ViewDialogFailedSuccess();
                            alert.showDialog(OrderDashboard.this, "Success!", false);

                        } else {
                            ViewDialogFailed alert = new ViewDialogFailed();
                            alert.showDialog(OrderDashboard.this, "Failed to store information!", true);
                        }


                    }


                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                vollyError(error);
            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                // Posting parameters to login url
                Map<String, String> params = new HashMap<String, String>();
                params.put("role", "");
                return params;
            }

        };

        // Añade la peticion a la cola
        AppController.getInstance().addToRequestQueue(eventoReq);
    }

    private void MeatAccept(String date, String time) {

        String dmt = "0";
        if (!TextUtils.isEmpty(damt.getText().toString())) {
            dmt = damt.getText().toString();
        }
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, "http://139.59.38.160/IziGourmet/Dashboard/OrderAccpetApp.php?id=" + UNIQUEID + "&name=" + _driverID + "&vehicle=" + _vehicleID
                + "&date=" + date + "&time=" + time + "&damt=" + dmt,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {
                            String[] pars = UniqueCode.split("\\.");
                            String con = TextUtils.join("", pars);
                            mDatabase.child("IziGourmet").child(con).child("ask").setValue("4");
                            mDatabase.child("IziGourmet").child(con).child("driverName").setValue(driver.getText().toString());
                            mDatabase.child("IziGourmet").child(con).child("driverVehicle").setValue(vehicle.getText().toString());
                            mDatabase.child("IziGourmet").child(con).child("DriverMobile").setValue(_mobile);
                            mDatabase.child("IziGourmet").child(con).child("ETR").setValue(_dateSubmit.getText().toString() + _timeSubmit.getText().toString());
                            if (!TextUtils.isEmpty(damt.getText().toString())) {
                                mDatabase.child("IziGourmet").child(con).child("pchanged").setValue("1");
                                mDatabase.child("IziGourmet").child(con).child("Cost").setValue(damt.getText().toString());
                            }
                            ViewDialogFailedSuccess alert = new ViewDialogFailedSuccess();
                            alert.showDialog(OrderDashboard.this, "Success!", false);

                        } else {
                            ViewDialogFailed alert = new ViewDialogFailed();
                            alert.showDialog(OrderDashboard.this, "Failed to store information!", true);
                        }


                    }


                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                vollyError(error);
            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                // Posting parameters to login url
                Map<String, String> params = new HashMap<String, String>();
                params.put("role", "");
                return params;
            }

        };

        // Añade la peticion a la cola
        AppController.getInstance().addToRequestQueue(eventoReq);
    }

    private void rejectOrder(String msg) {
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, "http://139.59.38.160/IziGourmet/Dashboard/OrderReject.php?id=" + UNIQUEID + "&reason=" + msg,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {
                            String[] pars = UniqueCode.split("\\.");
                            String con = TextUtils.join("", pars);
                            mDatabase.child("IziGourmet").child(con).removeValue();
                            ViewDialogFailedSuccess alert = new ViewDialogFailedSuccess();
                            alert.showDialog(OrderDashboard.this, "Success!", false);

                        } else {
                            ViewDialogFailed alert = new ViewDialogFailed();
                            alert.showDialog(OrderDashboard.this, "Failed to store information!", true);
                        }


                    }


                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                vollyError(error);
            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                // Posting parameters to login url
                Map<String, String> params = new HashMap<String, String>();
                params.put("role", "");
                return params;
            }

        };

        // Añade la peticion a la cola
        AppController.getInstance().addToRequestQueue(eventoReq);
    }

    private void acceptOrder(String msg, int kk) {
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, "http://139.59.38.160/IziGourmet/Dashboard/AcceptOrderApp.php?id=" + UNIQUEID + "&message=" + msg + "&role=" + kk,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {

                            String[] pars = UniqueCode.split("\\.");
                            String con = TextUtils.join("", pars);
                            if (_accepet == 0) {
                                mDatabase.child("IziGourmet").child(con).child("ask").setValue("2");

                            } else {
                                mDatabase.child("IziGourmet").child(con).child("ask").setValue("3");
                            }
                            mDatabase.child("IziGourmet").child(con).child("message").setValue(description.getText().toString());
                            ViewDialogFailedSuccess alert = new ViewDialogFailedSuccess();
                            alert.showDialog(OrderDashboard.this, "Success!", false);

                        } else {
                            ViewDialogFailed alert = new ViewDialogFailed();
                            alert.showDialog(OrderDashboard.this, "Failed to store information!", true);
                        }


                    }


                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                vollyError(error);
            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                // Posting parameters to login url
                Map<String, String> params = new HashMap<String, String>();
                params.put("role", "");
                return params;
            }

        };

        // Añade la peticion a la cola
        AppController.getInstance().addToRequestQueue(eventoReq);
    }

    private void open_date(final EditText _date) throws ParseException {
        int year;
        int months;
        int day;

        final Dialog dialog1 = new Dialog(OrderDashboard.this, R.style.ThemeTransparent);
        dialog1.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog1.setCancelable(true);
        dialog1.setContentView(R.layout.dailog_date);

        DatePicker date_ = dialog1.findViewById(R.id.datePickerExample);
        Button ok = dialog1.findViewById(R.id.button2);
        Calendar currCalendar = Calendar.getInstance();

        // Set the timezone which you want to display time.
        currCalendar.setTimeZone(TimeZone.getTimeZone("Asia/Kolkata"));

        year = currCalendar.get(Calendar.YEAR);
        months = currCalendar.get(Calendar.MONTH) + 1;
        day = currCalendar.get(Calendar.DAY_OF_MONTH);


        currCalendar.add(Calendar.HOUR, 3);
        Date date = simpleDateFormat.parse(simpleDateFormat.format(currCalendar.getTime()));
        date_.setMinDate(date.getTime());
        currCalendar.setTime(date);
        currCalendar.add(Calendar.HOUR, 240);
        Date date1 = simpleDateFormat.parse(simpleDateFormat.format(currCalendar.getTime()));

        date_.setMaxDate(date1.getTime());
        date_.init(year, months, day, new DatePicker.OnDateChangedListener() {
            @Override
            public void onDateChanged(DatePicker datePicker, int year, int month, int day) {
                _timeSubmit.setText("");
                if (month < 9) {
                    if (day < 10) {
                        _date.setText("0" + (month + 1) + "-" + "0" + day + "-" + year);
                    } else {
                        _date.setText("0" + (month + 1) + "-" + day + "-" + year);
                    }
                } else {
                    if (day < 10) {
                        _date.setText((month + 1) + "-" + "0" + day + "-" + year);
                    } else {
                        _date.setText((month + 1) + "-" + day + "-" + year);
                    }
                }

            }
        });

        ok.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog1.cancel();
            }
        });

        dialog1.show();

    }

    private void open_time(final EditText _time) {

        final Dialog dialog1 = new Dialog(OrderDashboard.this, R.style.ThemeTransparent);
        dialog1.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog1.setCancelable(true);
        dialog1.setContentView(R.layout.dialog_time);

        TimePicker timePicker = dialog1.findViewById(R.id.timePickerExample);
        Button ok = dialog1.findViewById(R.id.button3);
        Calendar currCalendar = Calendar.getInstance();

        try {
            Date dte = simpleDateFormat.parse(_dateSubmit.getText().toString());
            Calendar c = Calendar.getInstance();
            String dte1 = simpleDateFormat.format(c.getTime());
            Date dte2 = simpleDateFormat.parse(dte1);
            if (!dte.equals(dte2)) {
                timePicker.setOnTimeChangedListener(new TimePicker.OnTimeChangedListener() {
                    @Override
                    public void onTimeChanged(TimePicker timePicker, int hour1, int minute) {
                        String am_pm = (hour1 < 12) ? "AM" : "PM";
                        int hhh = (hour1 < 12) ? hour1 : (hour1 - 12);
                        if (minute < 10) {

                            _time.setText(hhh + ":0" + minute + "" + am_pm);
                        } else {
                            _time.setText(hhh + ":" + minute + "" + am_pm);
                        }


                    }
                });
            } else {
                final int hour = c.get(Calendar.HOUR_OF_DAY) + 1;
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                    timePicker.setHour(hour);
                } else {

                    timePicker.setCurrentHour(hour);
                }
                timePicker.setOnTimeChangedListener(new TimePicker.OnTimeChangedListener() {
                    @Override
                    public void onTimeChanged(TimePicker timePicker, int hour1, int minute) {
                        if (hour1 >= hour) {
                            String am_pm = (hour1 < 12) ? "AM" : "PM";
                            int hhh = (hour1 < 12) ? hour1 : (hour1 - 12);
                            if (minute < 10) {

                                _time.setText(hhh + ":0" + minute + "" + am_pm);
                            } else {
                                _time.setText(hhh + ":" + minute + "" + am_pm);
                            }

                        }
                    }
                });

            }
        } catch (ParseException e) {
            e.printStackTrace();
        }
        ok.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog1.cancel();
            }
        });
        dialog1.show();

    }

    public class ViewDialogFailed {

        public void showDialog(Activity activity, String msg, Boolean noDate) {
            if (!activity.isFinishing()) {
                final Dialog dialog1 = new Dialog(activity);
                dialog1.requestWindowFeature(Window.FEATURE_NO_TITLE);
                dialog1.setCancelable(false);

                dialog1.setContentView(R.layout.custom_dialog_failed);
                dialog1.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
                dialog1.getWindow().getAttributes().windowAnimations = R.style.DialogAnimation;
                TextView text = dialog1.findViewById(R.id.text_dialog);
                text.setText(msg);

                Button dialogButton = dialog1.findViewById(R.id.btn_dialog);

                dialogButton.setText("Ok");
                dialogButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {

                        dialog1.dismiss();
                    }
                });

                dialog1.show();
            }
        }
    }

    public class ViewDialogFailedSuccess {

        public void showDialog(Activity activity, String msg, Boolean noDate) {
            if (!activity.isFinishing()) {
                final Dialog dialog1 = new Dialog(activity);
                dialog1.requestWindowFeature(Window.FEATURE_NO_TITLE);
                dialog1.setCancelable(false);
                dialog1.setContentView(R.layout.custom_dialog_success);
                TextView text = dialog1.findViewById(R.id.text_dialog);
                text.setText(msg);

                Button dialogButton = dialog1.findViewById(R.id.btn_dialog);


                dialogButton.setText("Ok");

                dialogButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Intent i = new Intent(OrderDashboard.this, Tabs_past_future_ride.class);
                        startActivity(i);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                        finish();
                        dialog1.dismiss();
                    }
                });

                dialog1.show();


            }
        }
    }

    private class FirebaseDataListener_after_ride implements ValueEventListener {

        private String _ask;

        @Override
        public void onDataChange(DataSnapshot dataSnapshot) {

            int count = (int) dataSnapshot.getChildrenCount();
            if (count != 0) {
                _ask = (String) dataSnapshot.child("ask").getValue();
                if (_ask == null) {
                    _accepet = 0;
                } else if (_ask.contains("2") && !get1) {
                    get1 = true;
                    toggleBottomSheet();
                    _accepet = Integer.parseInt(_ask);

                } else if (_ask.contains("3") && !get2) {
                    get2 = true;
                    toggleBottomSheet();
                    _accepet = Integer.parseInt(_ask);

                } else if (_ask.contains("4") && !get3) {
                    get3 = true;
                    toggleBottomSheet();
                    _accepet = Integer.parseInt(_ask);
                } else if (_ask.contains("5") && !get4) {
                    get4 = true;
                    toggleBottomSheet();
                    _accepet = Integer.parseInt(_ask);
                } else if (_ask.contains("6") && !get5) {
                    //   mDatabase.child(con).removeEventListener(_firebaseLogs);
                    get5 = true;
                    Intent i = new Intent(OrderDashboard.this, Success.class);
                    i.putExtra("my_lat", My_lat);
                    i.putExtra("my_long", My_long);
                    i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    i.addFlags(Intent.FLAG_ACTIVITY_NO_ANIMATION);
                    startActivity(i);
                    finish();
                    overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

                }
            }


        }

        @Override
        public void onCancelled(DatabaseError databaseError) {

        }
    }
}

