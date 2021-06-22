package com.liteafrica.izigourmet.Activites.Ride_Later;

import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
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
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.Login.SignIn;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class AboutUs extends AppCompatActivity implements View.OnClickListener {
    private CoordinatorLayout coordinatorLayout;
    private Toolbar toolbar;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _phoneNo;
    private int paymentmode = 0;
    private ProgressDialog mProgressDialog = null;
    private TextView name, texts, addressed, zip;
    private TextView _mobile, _email;
    private TextView orders;
    private ImageView _i4;
    private SwipeRefreshLayout mSwipeRefreshLayout;

    @Override
    public void onClick(View view) {
        switch (view.getId()) {

            case R.id._i4: {
                if (_phoneNo != null) {
                    if (pref.get_food_money() != 0) {
                        pref.set_cID1(1);
                        Intent o = new Intent(AboutUs.this, GooglemapApp.class);
                        startActivity(o);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

                    } else {
                        if (!AboutUs.this.isFinishing()) {
                            new AlertDialog.Builder(AboutUs.this, R.style.AlertDialogTheme)
                                    .setTitle("Your cart is empty")
                                    .setMessage("Please add items to your cart.")
                                    .setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                            Intent o = new Intent(AboutUs.this, Canteen_Mainactivity.class);
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
                    if (!AboutUs.this.isFinishing()) {
                        new AlertDialog.Builder(AboutUs.this, R.style.AlertDialogTheme)
                                .setTitle("Please login.")
                                .setMessage("You need to login to complete your order.")
                                .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(AboutUs.this, SignIn.class);

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
                Intent i = new Intent(AboutUs.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                break;
        }

    }


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.aboutus);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        coordinatorLayout = findViewById(R.id
                .cor_home_main);
        toolbar = findViewById(R.id.toolbardd);
        setSupportActionBar(toolbar);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        toolbar.setTitle("About Us");


        name = findViewById(R.id._name);
        texts = findViewById(R.id._text);

        _email = findViewById(R.id._email);
        _mobile = findViewById(R.id._mobile);


        addressed = findViewById(R.id.addressd);
        zip = findViewById(R.id.zip);

        orders = findViewById(R.id.orders);
        if (pref.get_food_items() != 0) {
            orders.setText(String.valueOf(pref.get_food_items()));

        }

        TextView _address = findViewById(R.id.address);
        if (pref.getDropAt() != null) {
            _address.setText(pref.getDropAt());
        }
        _i4 = findViewById(R.id._i4);
        _i4.setOnClickListener(this);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent o = new Intent(AboutUs.this, Canteen_Mainactivity.class);
                startActivity(o);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            }

        });

        mSwipeRefreshLayout = findViewById(R.id.swipeToRefresh);
        mSwipeRefreshLayout.setColorSchemeResources(R.color.colorAccent);
        mSwipeRefreshLayout.setRefreshing(true);
    }


    @Override
    protected void onResume() {
        super.onResume();
        checkSingleProduct();
        mSwipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                checkSingleProduct();
                mSwipeRefreshLayout.setRefreshing(true);
            }
        });


    }

    private void checkSingleProduct() {

        if (!AboutUs.this.isFinishing()) {
            if (mProgressDialog == null) {
                mProgressDialog = new ProgressDialog(AboutUs.this, R.style.Theme_AppCompat_Dialog_Alert);
                mProgressDialog.setIcon(null);
                mProgressDialog.setTitle("Connecting IziGourmet");
                mProgressDialog.setMessage("Please wait");
                mProgressDialog.setIndeterminate(false);
                mProgressDialog.show();
            }
        }
        if (_phoneNo == null) {
            _phoneNo = "999999999";
        }
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_DETAILS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        JSONObject jsonObj = null;
                        try {
                            jsonObj = new JSONObject(response);


                            JSONArray shops = jsonObj.getJSONArray("shops");
                            for (int i = 0; i < shops.length(); i++) {
                                JSONObject c = shops.getJSONObject(i);

                                if (!c.isNull("Phone_No")) {
                                    name.setText(c.getString("Name"));
                                    texts.setText(c.getString("Aboutus"));
                                    _mobile.setText(c.getString("Phone_No"));
                                    _email.setText(c.getString("Email"));
                                    addressed.setText(c.getString("Address") + "," + c.getString("City") + "," + c.getString("State"));
                                    zip.setText("Zip Code " + c.getString("Pin_No"));
                                }
                            }


                        } catch (JSONException ex) {
                            ex.printStackTrace();
                        }


                        if (!AboutUs.this.isFinishing()) {
                            if (mProgressDialog != null) {
                                mProgressDialog.dismiss();
                            }
                        }
                        mSwipeRefreshLayout.setRefreshing(false);

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
                return params;
            }

        };
        AppController.getInstance().addToRequestQueue(eventoReq);

    }


    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        //replaces the default 'Back' button action
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent i = new Intent(AboutUs.this, Canteen_Mainactivity.class);
            startActivity(i);
            finish();
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
        }
        return true;
    }

    @Override
    protected void onStop() {
        super.onStop();
        if (!AboutUs.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
    }

    @Override
    protected void onPause() {
        super.onPause();
        if (!AboutUs.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (!AboutUs.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
    }
}

