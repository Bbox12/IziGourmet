package com.liteafrica.izigourmet.Activites.Ride_Later;

import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.EditText;
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
import com.liteafrica.izigourmet.Login.ServiceOffer;
import com.liteafrica.izigourmet.R;
import com.liteafrica.izigourmet.delivery.DrivermapApp;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class ContactUs extends AppCompatActivity implements View.OnClickListener {
    private CoordinatorLayout coordinatorLayout;
    private Toolbar toolbar;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _phoneNo;
    private int paymentmode = 0;
    private ProgressDialog mProgressDialog = null;
    private TextView _mobile, _email;
    private EditText name, email, message, _mobileNo;
    private TextView orders;
    private ImageView _i4;
    private String _Name;
    private SwipeRefreshLayout mSwipeRefreshLayout;

    @Override
    public void onClick(View view) {
        switch (view.getId()) {

            case R.id._i4: {
                if (_phoneNo != null) {
                    if (pref.get_food_money() != 0) {
                        pref.set_cID1(1);
                        Intent o = new Intent(ContactUs.this, GooglemapApp.class);
                        startActivity(o);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);


                    } else {
                        if (!ContactUs.this.isFinishing()) {
                            new AlertDialog.Builder(ContactUs.this, R.style.AlertDialogTheme)
                                    .setTitle("Your cart is empty")
                                    .setMessage("Please add items to your cart.")
                                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                            Intent o = new Intent(ContactUs.this, Canteen_Mainactivity.class);
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
                    if (!ContactUs.this.isFinishing()) {
                        new AlertDialog.Builder(ContactUs.this, R.style.AlertDialogTheme)
                                .setTitle("Please login.")
                                .setMessage("You need to login to complete your order.")
                                .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(ContactUs.this, ServiceOffer.class);

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
                Intent i = new Intent(ContactUs.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                break;

            case R.id.logout:
                if (!TextUtils.isEmpty(message.getText().toString())) {
                    if (!TextUtils.isEmpty(_mobileNo.getText().toString())) {
                        checkEmail();
                    } else {
                        _mobileNo.setError("Empty");
                    }
                } else {
                    message.setError("Empty");
                }
                break;
        }

    }


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.contactus);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        _Name = user.get(com.liteafrica.izigourmet.PrefManager.KEY_NAME);
        coordinatorLayout = findViewById(R.id
                .cor_home_main);
        toolbar = findViewById(R.id.toolbardd);
        setSupportActionBar(toolbar);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        toolbar.setTitle("ContactUs");

        Button finalsubmit = findViewById(R.id.logout);
        finalsubmit.setOnClickListener(this);

        _email = findViewById(R.id._email);
        _mobile = findViewById(R.id._mobile);

        name = findViewById(R.id._name);
        email = findViewById(R.id.email);
        message = findViewById(R.id.message);

        _mobileNo = findViewById(R.id._mobileno);

        name.setText(_Name);

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
                Intent o = new Intent(ContactUs.this, Canteen_Mainactivity.class);
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
        if (!ContactUs.this.isFinishing()) {
            if (mProgressDialog == null) {
                mProgressDialog = new ProgressDialog(ContactUs.this, R.style.Theme_AppCompat_Dialog_Alert);
                mProgressDialog.setIcon(null);
                mProgressDialog.setTitle("Connecting IziGourmet");
                mProgressDialog.setMessage("Please wait");
                mProgressDialog.setIndeterminate(false);
                mProgressDialog.show();
            }
        }
        if (_phoneNo == null) {
            _phoneNo = "999999999";
        } else {
            _mobileNo.setText(pref.getDriverPhone());
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
                                    _mobile.setText(c.getString("Phone_No"));
                                    _email.setText(c.getString("Email"));

                                }
                            }


                        } catch (JSONException ex) {
                            ex.printStackTrace();
                        }


                        if (!ContactUs.this.isFinishing()) {
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
        com.liteafrica.izigourmet.AppController.getInstance().addToRequestQueue(eventoReq);
    }

    private void checkEmail() {
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.STORE_MESSAGES,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {
                            ViewDialogFailedSuccess alert = new ViewDialogFailedSuccess();
                            alert.showDialog(ContactUs.this, "Success! Thank you for message.", false);
                        } else {
                            ViewDialogFailed alert = new ViewDialogFailed();
                            alert.showDialog(ContactUs.this, "Please check the information provided!", true);
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
                params.put("mobile", _phoneNo);
                params.put("phone", _mobileNo.getText().toString());
                params.put("email", email.getText().toString());
                params.put("message", message.getText().toString());
                return params;
            }

        };

        // Añade la peticion a la cola
        com.liteafrica.izigourmet.AppController.getInstance().addToRequestQueue(eventoReq);

    }

    private void vollyError(VolleyError error) {

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
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        //replaces the default 'Back' button action
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent i = new Intent(ContactUs.this, Canteen_Mainactivity.class);
            startActivity(i);
            finish();
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
        }
        return true;
    }

    @Override
    protected void onStop() {
        super.onStop();
        if (!ContactUs.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
    }

    @Override
    protected void onPause() {
        super.onPause();
        if (!ContactUs.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (!ContactUs.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
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
                        if (pref.getResposibility() == 0) {
                            Intent i = new Intent(ContactUs.this, Canteen_Mainactivity.class);
                            startActivity(i);
                            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                        } else {
                            if (pref.getResposibility() == 1) {
                                if (pref.get_food_money() != 0) {
                                    Intent i = new Intent(ContactUs.this, GooglemapApp.class);
                                    startActivity(i);
                                    overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                } else {
                                    Intent i = new Intent(ContactUs.this, Canteen_Mainactivity.class);
                                    startActivity(i);
                                    overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                }
                            } else if (pref.getResposibility() == 2) {
                                Intent i = new Intent(ContactUs.this, DrivermapApp.class);
                                startActivity(i);
                                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                            }
                        }
                        dialog1.dismiss();
                    }
                });

                dialog1.show();


            }
        }
    }
}
