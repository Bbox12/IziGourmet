package com.liteafrica.izigourmet.Activites.Ride_Later;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.ExpandableListView;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.coordinatorlayout.widget.CoordinatorLayout;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
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
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.Adapters.ExpandableListAdapter;
import com.liteafrica.izigourmet.Login.ServiceOffer;
import com.liteafrica.izigourmet.Model.User;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;


/**
 * Created by parag on 18/02/18.
 */

public class Ride_later_tabs extends AppCompatActivity implements View.OnClickListener {


    private double My_lat = 0, My_long = 0;
    private ProgressBar progressBar;
    private TextView no_rides;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _PhoneNo;
    private CoordinatorLayout coordinatorLayout;
    private ExpandableListAdapter listAdapter;
    private ExpandableListView expListView;
    private ImageView _i4, _arrow;
    private TextView orders, _address;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_past);
        coordinatorLayout = findViewById(R.id
                .cor_home_main);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);


        expListView = findViewById(R.id.lvExp);
        no_rides = findViewById(R.id.no_past);
        progressBar = findViewById(R.id.progressBarpast);
        _i4 = findViewById(R.id._i4);
        _i4.setOnClickListener(this);
        _arrow = findViewById(R.id.arrow);
        _arrow.setOnClickListener(this);
        orders = findViewById(R.id.orders);

        _address = findViewById(R.id.address);
        if (pref.getDropAt() != null) {
            _address.setText(pref.getDropAt());
        }
        if (pref.get_food_items() != 0) {
            orders.setText(String.valueOf(pref.get_food_items()));

        }


    }

    @Override
    public void onResume() {
        super.onResume();

        final ArrayList<String> listDataHeader = new ArrayList<String>();

        final HashMap<String, ArrayList<User>> listDataChild = new HashMap<String, ArrayList<User>>();
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_MENU,
                new Response.Listener<String>() {


                    @Override
                    public void onResponse(String response) {

                        Log.w("mainlayout", response);
                        try {


                            JSONObject jsonObj = new JSONObject(response);
                            JSONArray bookings = jsonObj.getJSONArray("bookings");
                            for (int i = 0; i < bookings.length(); i++) {
                                JSONObject c = bookings.getJSONObject(i);
                                ArrayList<User> mItems = new ArrayList<User>();
                                User item = new User();
                                item.setType(c.getInt("Type"));
                                item.setEnd_time(c.getString("End_Time"));
                                item.setEnd_date(c.getString("End_Date"));
                                item.setCost(c.getString("Cost"));
                                item.setOrderID(c.getString("OrderID"));
                                listDataHeader.add(c.getString("OrderID"));
                                item.setDelivered(c.getInt("Delivered"));
                                item.setpCost(c.getString("pCost"));
                                item.setTime(c.getString("ETR"));
                                item.setPaymentVerified(c.getInt("PaymentVerified"));
                                item.setPaymentMode(c.getInt("PaymentMode"));
                                item.setIs_Paid(c.getInt("Is_Paid"));
                                mItems.add(item);
                                listDataChild.put(c.getString("OrderID"), mItems);
                            }
                            if (listDataChild.size() != 0) {
                                listAdapter = new ExpandableListAdapter(Ride_later_tabs.this, listDataHeader, listDataChild);
                                listAdapter.setPref(pref);
                                listAdapter.setCoordinatorlayout(coordinatorLayout);
                                expListView.setAdapter(listAdapter);
                            } else {
                                expListView.setVisibility(View.GONE);
                                no_rides.setVisibility(View.VISIBLE);
                            }

                        } catch (final JSONException e) {
                            Log.e("HI", "Json parsing error: " + e.getMessage());
                        }


                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d("uuu", "Error: " + error.getMessage());
                vollyError(error);


            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("_mId", _PhoneNo);
                return params;
            }

        };
        eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        com.liteafrica.izigourmet.AppController.getInstance().addToRequestQueue(eventoReq);
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        Intent o = new Intent(Ride_later_tabs.this, Canteen_Mainactivity.class);
        startActivity(o);
        finish();
        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
        return true;
    }


    private void vollyError(VolleyError error) {
        if (error instanceof TimeoutError || error instanceof NoConnectionError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        } else if (error instanceof AuthFailureError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        } else if (error instanceof ServerError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Server Error.Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        } else if (error instanceof NetworkError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network Error. Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        } else if (error instanceof ParseError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Data Error. Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        }
    }


    @Override
    public void onClick(View v) {
        switch (v.getId()) {

            case R.id._i4: {
                if (_PhoneNo != null) {
                    if (pref.get_food_money() != 0) {
                        pref.set_cID1(1);
                        Intent o = new Intent(Ride_later_tabs.this, GooglemapApp.class);
                        startActivity(o);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

                    } else {
                        if (!Ride_later_tabs.this.isFinishing()) {
                            new AlertDialog.Builder(Ride_later_tabs.this, R.style.AlertDialogTheme)
                                    .setTitle("Your cart is empty")
                                    .setMessage("Please add items to your cart.")
                                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                            Intent o = new Intent(Ride_later_tabs.this, Canteen_Mainactivity.class);
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
                } else {
                    if (!Ride_later_tabs.this.isFinishing()) {
                        new AlertDialog.Builder(Ride_later_tabs.this, R.style.AlertDialogTheme)
                                .setTitle("Please login.")
                                .setMessage("You need to login to complete your order.")
                                .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(Ride_later_tabs.this, ServiceOffer.class);

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

            case R.id.arrow:
                Intent i = new Intent(Ride_later_tabs.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                break;

        }

    }
}
