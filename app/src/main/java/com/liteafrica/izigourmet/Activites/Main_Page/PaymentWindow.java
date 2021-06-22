package com.liteafrica.izigourmet.Activites.Main_Page;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.net.Uri;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.TextUtils;
import android.text.format.Formatter;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.core.widget.NestedScrollView;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkError;
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.appbar.AppBarLayout;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Activites.Canteen.SelectePaymentOption;
import com.liteafrica.izigourmet.Adapters.BookingAdapter;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.FCM.NotificationUtils;
import com.liteafrica.izigourmet.Login.ServiceOffer;
import com.liteafrica.izigourmet.Model.Foods;
import com.liteafrica.izigourmet.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.net.InetAddress;
import java.net.NetworkInterface;
import java.net.UnknownHostException;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Set;

import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;

public class PaymentWindow extends AppCompatActivity implements
        View.OnClickListener {
    private static final String TAG = PaymentWindow.class.getSimpleName();
    DecimalFormat dft = new DecimalFormat("0.00");
    DecimalFormat dfto = new DecimalFormat("0.000000");
    SimpleDateFormat simpleDateFormat =
            new SimpleDateFormat("yyy-MM-dd");
    private RecyclerView _moreRv;
    private CoordinatorLayout coordinatorLayout;
    private Toolbar toolbar;
    private String User_image;
    private String User_name;
    private String regId;
    private DatabaseReference mDatabase;
    private ScrollView L1;
    private AppBarLayout AppBar;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _phoneNo;
    private boolean isInternetPresent = false;
    private String User_accept;
    private boolean first = false;
    private String con;
    private boolean stoped = false;
    private String _rate;
    private TextView _moneyValue, _itemValue;
    private TextView _estimate;
    private String ETR = "10";
    private boolean _second = false;
    private ProgressDialog mProgressDialog;
    private TextView discount, _moreValue, _servicable, _reason, minimum_order, minimum_person, canteen_time, canteen_time1;
    private DecimalFormat df = new DecimalFormat("0.00");
    private ArrayList<Foods> mItems = new ArrayList<Foods>();
    private Button _cancel, _confirm;
    private LinearLayoutManager mLayoutManager;
    private NestedScrollView _nsScroll;
    private boolean _end = false;
    private int hour;
    private TextView _tAmount, _dAmount,  _payAmount;
    private String _total;
    private int j = 0;
    private String commaSeparatedValues;
    private View _v1;
    private RelativeLayout _totals;
    private LinearLayout _L2;
    private String OTP;


    public static String getMobileIPAddress() {
        try {
            List<NetworkInterface> interfaces = Collections.list(NetworkInterface.getNetworkInterfaces());
            for (NetworkInterface intf : interfaces) {
                List<InetAddress> addrs = Collections.list(intf.getInetAddresses());
                for (InetAddress addr : addrs) {
                    if (!addr.isLoopbackAddress()) {
                        return addr.getHostAddress();
                    }
                }
            }
        } catch (Exception ignored) {
        } // for now eat exceptions
        return null;
    }


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        setContentView(R.layout.paymentwindow);
        _totals = findViewById(R.id._total);
        _cancel = findViewById(R.id._cancel_book);
        _confirm = findViewById(R.id._confirm_book);
        _confirm.setEnabled(false);
        _cancel.setEnabled(false);
        _moreRv = findViewById(R.id.moreRvs);
        _moreRv.setNestedScrollingEnabled(false);
        _moneyValue = findViewById(R.id.canteen_amounts);
        _itemValue = findViewById(R.id._noofItemss);
        _tAmount = findViewById(R.id._tamounts);
        _dAmount = findViewById(R.id._damounts);
        _payAmount = findViewById(R.id._payamounts);
        AppBar = findViewById(R.id.app_bar_main);
        coordinatorLayout = findViewById(R.id.cor_home_main);
        toolbar = findViewById(R.id.toolbar_main);
        setSupportActionBar(toolbar);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(true);

       
        mDatabase = FirebaseDatabase.getInstance().getReference();
        _estimate = findViewById(R.id._estimate);
    

        pref.set_cID1(0);

        _L2 = findViewById(R.id._L2);


        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
                overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);
            }
        });

    
    }

    public String getWifiIPAddress() {
        WifiManager wifiMgr = (WifiManager) getApplicationContext().getSystemService(WIFI_SERVICE);
        WifiInfo wifiInfo = wifiMgr.getConnectionInfo();
        int ip = wifiInfo.getIpAddress();
        return Formatter.formatIpAddress(ip);
    }

  
    @Override
    protected void onResume() {
        super.onResume();
        if (_phoneNo != null) {
            stoped = false;
            _confirm.setVisibility(View.VISIBLE);
            _cancel.setVisibility(View.VISIBLE);
            _confirm.setEnabled(true);
            _cancel.setEnabled(true);
            _cancel.setOnClickListener(this);
            _confirm.setOnClickListener(this);
            
            if (!PaymentWindow.this.isFinishing()) {
                if (mProgressDialog == null) {
                    mProgressDialog = new ProgressDialog(PaymentWindow.this, R.style.Theme_AppCompat_Light_Dialog_MinWidth);
                    mProgressDialog.setIcon(R.mipmap.ic_launcher);
                    mProgressDialog.setTitle("Getting details of your order");
                    mProgressDialog.setMessage("please wait...");
                    mProgressDialog.setIndeterminate(false);
                    mProgressDialog.show();
                }
            }

            int Rate = 0;
            if (pref.get_packagesharedPreferences() != null) {
                mItems.clear();
                Set<String> set = pref.get_packagesharedPreferences();

                for (String s : set) {
                    String[] pars = s.split("\\^");
                    Foods items = new Foods();
                    items.setID(Integer.parseInt(pars[0]));
                    items.setNoofItems((int) Double.parseDouble(pars[1]));
                    items.seteTEZ_Price((int) Double.parseDouble(pars[2]));
                    items.setPhoto(pars[4]);
                    Rate = (int) (Double.parseDouble(pars[2]) + Rate);
                    items.setMenu_Name((pars[3]));
                    mItems.add(items);
                    pref.set_food_money(Rate);
                }
                if (mItems.size() > 0) {
                    if (mProgressDialog != null) {
                        mProgressDialog.dismiss();
                    }
                    _moreRv.setVisibility(View.VISIBLE);
                    BookingAdapter sAdapter1 = new BookingAdapter(PaymentWindow.this, mItems);
                    sAdapter1.notifyDataSetChanged();
                    sAdapter1.setPref(pref);
                    sAdapter1.setFrom(j);
                    mLayoutManager = new LinearLayoutManager(PaymentWindow.this, LinearLayoutManager.VERTICAL, false);
                    _moreRv.setLayoutManager(mLayoutManager);
                    _moreRv.setItemAnimator(new DefaultItemAnimator());
                    _moreRv.setAdapter(sAdapter1);
                    _moreRv.setHasFixedSize(true);
                    _tAmount.setText("R " + df.format(Rate));
                } else {
                    Intent o = new Intent(PaymentWindow
                            .this, Canteen_Mainactivity.class);
                    startActivity(o);
                    finish();
                    overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                }

            }


            _total = df.format(Rate);
            Log.w("Dis", _total);

            _payAmount.setText("R " + _total);
            //  _moneyValue.setText(_total);
            if (pref.getTotal2() == null) {
                if (Rate != 0) {
                    pref.setTotal(String.valueOf((_total)));
                    _moneyValue.setText(pref.getTotal());
                }
            } else {
                _moneyValue.setText(pref.getTotal2());
            }
            _confirm.setEnabled(true);
            _cancel.setEnabled(true);

            _itemValue.setText("No of items " + pref.get_food_items());

        } else {
            if (!PaymentWindow.this.isFinishing()) {
                new AlertDialog.Builder(PaymentWindow.this, R.style.AlertDialogTheme)
                        .setTitle("Please login.")
                        .setMessage("You need to login to complete your order.")
                        .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                dialog.cancel();
                                Intent o = new Intent(PaymentWindow
                                        .this, ServiceOffer.class);
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
    public void onClick(View view) {

        switch (view.getId()) {


         
            case R.id._cancel_book:
                if (!PaymentWindow.this.isFinishing()) {
                    new AlertDialog.Builder(PaymentWindow.this, R.style.AlertDialogTheme)
                            .setIcon(R.mipmap.ic_launcher)
                            .setTitle("Are you sure?")
                            .setMessage("Press Ok to cancel your order")
                            .setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {
                                    pref.set_food_items(0);
                                    pref.set_food_money(0);
                                    pref.setPref1(0);
                                    pref.setPref2(0);
                                    pref.setPref3(null);
                                    pref.setPref4(null);
                                    pref.setTotal(null);
                                    pref.setTotal2(null);
                                    pref.packagesharedPreferences(null);
                                    pref.setDelivery(0);
                                    if (j == 0) {
                                        Intent i = new Intent(PaymentWindow.this, Canteen_Mainactivity.class);
                                        startActivity(i);
                                        finish();
                                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                    } else {
                                        Intent i = new Intent(PaymentWindow.this, PaymentWindow.class);
                                        startActivity(i);
                                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                    }
                                    dialog.cancel();
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


                break;


            case R.id._confirm_book:
                if (pref.get_food_money() !=0) {
                    go();
                }

                break;
            case R.id.cancelorder:
                openEditor();
                break;
            default:
                break;
        }


    }

    private void openEditor() {
        if (!PaymentWindow.this.isFinishing()) {
            AlertDialog.Builder alertbox = new AlertDialog.Builder(this);

            LinearLayout ll_alert_layout = new LinearLayout(this);
            ll_alert_layout.setOrientation(LinearLayout.VERTICAL);
            final EditText ed_input = new EditText(this);
            ll_alert_layout.addView(ed_input);

            alertbox.setTitle("Reason for cancellation");

            ed_input.setHint("Type here....");
            //setting linear layout to alert dialog

            alertbox.setView(ll_alert_layout);

            alertbox.setNegativeButton("CANCEL",
                    new DialogInterface.OnClickListener() {

                        public void onClick(DialogInterface arg0, int arg1) {

                            arg0.cancel();

                        }
                    });


            alertbox.setPositiveButton("OK",
                    new DialogInterface.OnClickListener() {

                        public void onClick(final DialogInterface arg0, int arg1) {
                            new PaymentWindow.Delete_Ride_Completely().execute(ed_input.getText().toString());
                        }
                    });
            alertbox.show();
        }
    }

   

    private void go() {
        upload();
    }

    private void upload() {
        if (!PaymentWindow.this.isFinishing()) {
            if (mProgressDialog == null) {
                mProgressDialog = new ProgressDialog(PaymentWindow.this, R.style.Theme_AppCompat_Light_Dialog_MinWidth);
                mProgressDialog.setIcon(R.mipmap.ic_launcher);
                mProgressDialog.setTitle("Stroing order");
                mProgressDialog.setMessage("please wait...");
                mProgressDialog.setIndeterminate(false);
                mProgressDialog.show();
            }else{
                mProgressDialog.setTitle("Stroing order");
                mProgressDialog.setMessage("please wait...");
                mProgressDialog.setIndeterminate(false);
                mProgressDialog.show();
            }
        }

        if (OTP == null) {
            List<String> TotalDays = new ArrayList<String>();
            if (pref.get_packagesharedPreferences() != null) {
                Set<String> set = pref.get_packagesharedPreferences();
                TotalDays.addAll(set);
            }
            commaSeparatedValues = TextUtils.join(",", TotalDays);


            StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.USER_BOOKING_RIDE,
                                        new Response.Listener<String>() {
                                            @Override
                                            public void onResponse(String response) {

                                                Log.e("volley", response);


                                                try {
                                                    String[] pars = response.split("error");
                                                    if (pars[1].contains("false")) {
                                                        String[] pars_ = pars[1].split("false,");
                                                        JSONObject jObj = new JSONObject("{".concat(pars_[1]));
                                                        JSONObject user = jObj.getJSONObject("user");
                                                        pref.setUniqueRide(user.getString("unique_id"));
                                                        OTP = String.valueOf(user.getInt("OTP"));
                                                        if (pref.getUniqueRide() != null) {
                                                            String[] pars1 = pref.getUniqueRide().split("\\.");
                                                            String con = TextUtils.join("", pars1);
                                                            pref.setCon(con);

                                                            if (OTP != null) {
                                                                pref.set_ride(0);
                                                                pref.setOrder(String.valueOf(OTP));
                                                                mDatabase = FirebaseDatabase.getInstance().getReference();
                                                                mDatabase.child("IziGourmet").child(con).child("con").setValue(pref.getCon());
                                                                mDatabase.child("IziGourmet").child(con).child("UserMobile").setValue(_phoneNo);
                                                                mDatabase.child("IziGourmet").child(con).child("OTP").setValue(OTP);
                                                                mDatabase.child("IziGourmet").child(con).child("From_Address").setValue(pref.getDistance());
                                                                mDatabase.child("IziGourmet").child(con).child("Book_To_Latitude").setValue(pref.getDropLat());
                                                                mDatabase.child("IziGourmet").child(con).child("Book_To_Longitude").setValue(pref.getDropLong());
                                                                mDatabase.child("IziGourmet").child(con).child("Cost").setValue(_total);
                                                                mDatabase.child("IziGourmet").child(con).child("Order").setValue(commaSeparatedValues);
                                                                mDatabase.child("IziGourmet").child(con).child("Type").setValue(String.valueOf(pref.getGoTRide()));
                                                                pref.setDelivery(1);
                                                                Intent i = new Intent(PaymentWindow.this, SelectePaymentOption.class);
                                                                startActivity(i);
                                                                finish();
                                                                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                                            }
                                                        }
                                                    } else {
                                                        if (!PaymentWindow.this.isFinishing()) {
                                                            new AlertDialog.Builder(PaymentWindow.this, R.style.AlertDialogTheme)
                                                                    .setTitle("Failed to create request!")
                                                                    .setIcon(R.mipmap.ic_launcher)
                                                                    .setMessage("Please order another time")
                                                                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                                                        @Override
                                                                        public void onClick(DialogInterface dialog, int which) {
                                                                            recreate();
                                                                            dialog.cancel();
                                                                        }
                                                                    })
                                                                    .show();
                                                        }
                                                    }
                                                } catch (final JSONException e) {
                                                    Log.e("HI", "Json parsing error: " + e.getMessage());


                                                }

                                            }



                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    vollyerror(error);

                }

            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("mobile", _phoneNo);
                    params.put("data", commaSeparatedValues);
                    params.put("total", _total);
                    params.put("gross", _tAmount.getText().toString());
                    params.put("address", pref.getDropAt());
                    params.put("from_lat", String.valueOf(pref.getDropLat()));
                    params.put("from_long", String.valueOf(pref.getDropLong()));
                    params.put("canteen", String.valueOf(pref.getCanteen()));
                    params.put("ride", String.valueOf(pref.getGoTRide()));
                    return params;
                }

            };
            AppController.getInstance().addToRequestQueue(eventoReq);
        }

    }

    private void vollyerror(VolleyError error) {
        if (error instanceof TimeoutError || error instanceof NoConnectionError) {
            
            
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_LONG)
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
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_LONG)
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
                    .make(coordinatorLayout, "Server Error.Please try another time", Snackbar.LENGTH_LONG)
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
                    .make(coordinatorLayout, "Network Error. Please try another time", Snackbar.LENGTH_LONG)
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
                    .make(coordinatorLayout, "Data Error. Please try another time", Snackbar.LENGTH_LONG)
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

 
    @Override
    protected void onStart() {
        super.onStart();
        stoped = false;

    }

    @Override
    protected void onStop() {
        super.onStop();
        stoped = true;
    

        if (mProgressDialog != null) {
            mProgressDialog.dismiss();
        }

    }

    @Override
    protected void onPause() {
        super.onPause();
        stoped = true;
    
        if (mProgressDialog != null) {
            mProgressDialog.dismiss();
        }


    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        stoped = true;
    
        if (mProgressDialog != null) {
            mProgressDialog.dismiss();
        }

    }


    private class Delete_Ride_Completely extends AsyncTask<String, Integer, String> {


        private boolean success;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        protected String doInBackground(String... args) {
            return uploadFile(args[0]);
        }

        private String uploadFile(String reason) {
            // TODO Auto-generated method stub
            String res = null;

            try {

                RequestBody requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("mobile", _phoneNo)
                        .addFormDataPart("unique_id", pref.getUniqueRide())
                        .addFormDataPart("reason", reason)
                        .build();

                Request request = new Request.Builder()
                        .url(com.liteafrica.izigourmet.Config_URL.DELETE_RIDE_ALL)
                        .post(requestBody)
                        .build();
                OkHttpClient client = new OkHttpClient();
                okhttp3.Response response = client.newCall(request).execute();
                res = response.body().string();
                String[] pars = res.split("error");
                success = pars[1].contains("false");

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
            if (success) {
                if (pref.getUniqueRide() != null) {
                    String[] pars = pref.getUniqueRide().split("\\.");
                    String con = TextUtils.join("", pars);
                    mDatabase.child("IziGourmet").child(con).removeValue();
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
                    Intent op = new Intent(PaymentWindow.this, Canteen_Mainactivity.class);
                    op.putExtra("from", 1);
                    startActivity(op);
                    finish();
                    overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                }
            } else {
                Snackbar.make(PaymentWindow.this.getWindow().getDecorView().getRootView(), "Update failed", Snackbar.LENGTH_LONG).show();

            }

        }

    }

}
