package com.liteafrica.izigourmet.Activites.Canteen;

import android.content.Intent;
import android.graphics.Color;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.Bundle;
import android.text.TextUtils;
import android.text.format.Formatter;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
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
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.liteafrica.izigourmet.Adapters.generallnfoRv;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.Model.Contacts;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.net.InetAddress;
import java.net.NetworkInterface;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class NotificationAll extends AppCompatActivity {

    private static final String TAG = NotificationAll.class.getSimpleName();
    private static final int RESULT_PICK_CONTACT = 101;
    public boolean success;
    private Toolbar toolbar;
    private double My_lat = 0, My_long = 0;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _PhoneNo;
    private String phoneNo;
    private String name;
    private RecyclerView Sosrv;
    private ArrayList<Contacts> mItems = new ArrayList<Contacts>();
    private String mobileIp;
    private ProgressBar progressBar;
    private CoordinatorLayout coordinatorLayout;
    private DatabaseReference mDatabase;
    private String _familyPhone;
    private EditText _t1;
    private String _Name;
    private TextView textView101, textView102;

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
        } catch (Exception ex) {
        } // for now eat exceptions
        return null;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.notificationlayout);
        coordinatorLayout = findViewById(R.id.em);
        toolbar = findViewById(R.id.toolbar_later_sos);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        Sosrv = findViewById(R.id.sosrv);
        _t1 = findViewById(R.id._t1);

        progressBar = findViewById(R.id.progressBaremergency);
        progressBar.setVisibility(View.VISIBLE);

        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        _Name = user.get(com.liteafrica.izigourmet.PrefManager.KEY_NAME);

        textView101 = findViewById(R.id.textView101);
        textView102 = findViewById(R.id.textView102);

        textView101.setText("Notification");
        textView102.setText("");

        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(NotificationAll.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);
            }
        });
        mobileIp = getMobileIPAddress();
        if (TextUtils.isEmpty(mobileIp)) {
            mobileIp = getWifiIPAddress();
        }
        mDatabase = FirebaseDatabase.getInstance().getReference();
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
        if (_PhoneNo == null) {
            _PhoneNo = "9999999999";
        }
        go();
    }

    private void go() {
        mItems.clear();
        progressBar.setVisibility(View.VISIBLE);
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_DETAILS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("ccc", response);
                        progressBar.setVisibility(View.GONE);
                        try {
                            JSONObject jsonObj = new JSONObject(response);

                            // Getting JSON Array node

                            JSONArray Contacts = jsonObj.getJSONArray("notification");

                            for (int j = 0; j < Contacts.length(); j++) {

                                JSONObject c = Contacts.getJSONObject(j);
                                Contacts item = new Contacts();
                                item.setMessage(c.getString("Message"));
                                item.setPhoto(c.getString("Photo"));
                                item.setDate(c.getString("Date"));
                                item.setTime(c.getString("Time"));
                                mItems.add(item);


                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        if (mItems.size() != 0) {
                            Sosrv.setVisibility(View.VISIBLE);
                            _t1.setVisibility(View.GONE);
                            generallnfoRv sAdapter = new generallnfoRv(NotificationAll.this, mItems);
                            sAdapter.notifyDataSetChanged();
                            sAdapter.setFrom(1);
                            Sosrv.setAdapter(sAdapter);
                            LinearLayoutManager mLayoutManager = new LinearLayoutManager(NotificationAll.this);
                            mLayoutManager.setOrientation(LinearLayoutManager.VERTICAL);
                            Sosrv.setLayoutManager(mLayoutManager);

                        } else {
                            Sosrv.setVisibility(View.GONE);
                            _t1.setVisibility(View.VISIBLE);
                        }

                    }


                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(TAG, "Error: " + error.getMessage());
                if (error instanceof TimeoutError || error instanceof NoConnectionError) {
                    Snackbar snackbar = Snackbar
                            .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_LONG)
                            .setAction("Refresh", new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    go();
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
                                    go();
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
                                    go();
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
                                    go();
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
                                    go();
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
                params.put("_mId", "1");
                return params;
            }
        };

        // Añade la peticion a la cola
        AppController.getInstance().addToRequestQueue(eventoReq);
    }


    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        //replaces the default 'Back' button action
        if (keyCode == KeyEvent.KEYCODE_BACK) {

            Intent o = new Intent(NotificationAll.this, Canteen_Mainactivity.class);
            o.putExtra("from", 1);
            startActivity(o);
            finish();
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

        }
        return true;
    }


}

