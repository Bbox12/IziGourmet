package com.liteafrica.izigourmet.Activites.Ride_Later;

import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
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
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.Adapters.BookingAdapter;
import com.liteafrica.izigourmet.Model.Foods;
import com.liteafrica.izigourmet.Model.User;
import com.liteafrica.izigourmet.R;
import com.squareup.picasso.Picasso;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

/**
 * Created by parag on 22/02/18.
 */

public class PastRides extends AppCompatActivity implements View.OnClickListener {
    private static final String TAG = PastRides.class.getSimpleName();
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
    private LinearLayout _L1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.past_rides);
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
        Tool1.setText("Your order on ");
        delivery = findViewById(R.id.pmode);
        coordinatorLayout = findViewById(R.id.cor_home_eats);
        past_name_driver = findViewById(R.id.past_name_driver);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(PastRides.this, Ride_later_tabs.class);
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

        _i4 = findViewById(R.id._i4);
        _i4.setOnClickListener(this);

        y5 = findViewById(R.id.y5);
        y5.setOnClickListener(this);
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
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_FOODSS,
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
                                        items.setPhoto(c.getString("Photo"));
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
                                        items.setType(c.getInt("Type"));
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
                                        items.setShopName(c.getString("Name"));
                                        items.setShopAddress(c.getString("Address"));
                                        mItems.add(items);
                                    }
                                }

                            }
                            mSwipeRefreshLayout.setRefreshing(false);
                            go(mItems);

                        } catch (final JSONException e) {
                            Log.e("HI", "Json parsing error: " + e.getMessage());


                        }


                        BookingAdapter sAdapter1 = new BookingAdapter(PastRides.this, mUser);
                        sAdapter1.notifyDataSetChanged();
                        sAdapter1.setPref(pref);
                        sAdapter1.setFrom(1);
                        LinearLayoutManager mLayoutManager = new LinearLayoutManager(PastRides.this, LinearLayoutManager.VERTICAL, false);
                        _moreRv.setLayoutManager(mLayoutManager);
                        _moreRv.setItemAnimator(new DefaultItemAnimator());
                        _moreRv.setAdapter(sAdapter1);
                        _moreRv.setHasFixedSize(true);

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d("uuu", "Error: " + error.getMessage());
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

        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("_mId", _PhoneNo);
                params.put("submenu", UNIQUEID);
                return params;
            }

        };

        com.liteafrica.izigourmet.AppController.getInstance().addToRequestQueue(eventoReq);
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

                Picasso.with(PastRides.this)
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


            if (mItems.get(0).getDrivername(0) != null &&
                    !TextUtils.isEmpty(mItems.get(0).getDrivername(0)) && !mItems.get(0).getDrivername(0).contains("null")) {
                past_name_driver.setText(mItems.get(0).getDrivername(0));
                _L1.setVisibility(View.VISIBLE);
            } else {
                _L1.setVisibility(View.GONE);
            }

            if(mItems.get(0).getType(0) == 0) {
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
            }else{
                address.setVisibility(View.VISIBLE);
                address.setText(mItems.get(0).getShopName(0)+","+mItems.get(0).getShopAddress(0));
                delivery.setText("Store Pickup");
                y5.setVisibility(View.GONE);
                _L1.setVisibility(View.VISIBLE);
                ETR.setVisibility(View.GONE);
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

        Intent o = new Intent(PastRides.this, Ride_later_tabs.class);
        o.putExtra("my_lat", My_lat);
        o.putExtra("my_long", My_long);
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
        String inputPattern = "YYYY-MM-ddHH:mm";
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
            String inputPattern1 = "YYYY-MM-dd";
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

            case R.id._i4: {

                if (pref.get_food_money() != 0) {
                    pref.set_cID1(1);
                    Intent o = new Intent(PastRides.this, GooglemapApp.class);
                    startActivity(o);
                    overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);


                } else {
                    if (!PastRides.this.isFinishing()) {
                        new AlertDialog.Builder(PastRides.this, R.style.AlertDialogTheme)
                                .setTitle("Your cart is empty")
                                .setMessage("Please add items to your cart.")
                                .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(PastRides.this, Canteen_Mainactivity.class);
                                        startActivity(o);
                                        finish();
                                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                    }
                                })
                                .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                    }
                                })
                                .show();
                    }
                }


            }
            break;

            case R.id.y5: {
                if (!PastRides.this.isFinishing()) {
                    final Dialog dialog = new Dialog(PastRides.this, R.style.AlertDialogTheme);

                    dialog.setCancelable(true);
                    dialog.setCanceledOnTouchOutside(true);
                    dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
                    dialog.setContentView(R.layout.dialogeft);

                    dialog.show();

                }
            }
            break;


        }

    }
}
