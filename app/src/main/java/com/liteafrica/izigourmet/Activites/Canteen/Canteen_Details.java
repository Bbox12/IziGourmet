package com.liteafrica.izigourmet.Activites.Canteen;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.core.widget.NestedScrollView;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.recyclerview.widget.StaggeredGridLayoutManager;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

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
import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.snackbar.Snackbar;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.Activites.Main_Page.MapActivity;
import com.liteafrica.izigourmet.Adapters.All_fragment_adapter;
import com.liteafrica.izigourmet.Adapters.secondadapter;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.ConnectionDetector;
import com.liteafrica.izigourmet.Login.ServiceOffer;
import com.liteafrica.izigourmet.LruBitmapCache;
import com.liteafrica.izigourmet.Model.Foods;
import com.liteafrica.izigourmet.Model._menu;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class Canteen_Details extends AppCompatActivity implements View.OnClickListener {

    public static final int PAGE_START = 1;
    Boolean isInternetPresent = false;
    SimpleDateFormat simpleDateFormat =
            new SimpleDateFormat("yyy-MM-dd");
    int itemCount = 0;
    private ConnectionDetector cd;
    private com.liteafrica.izigourmet.PrefManager pref;
    private double My_lat = 0, My_long = 0;
    private String _phoneNo;
    private ProgressBar progressBar;
    private CoordinatorLayout coordinatorLayout;
    private RecyclerView _moreRv;
    private ArrayList<String> mItems = new ArrayList<String>();
    private boolean _collapsed = false;
    private RelativeLayout Lweb;
    private String _URL;
    private int _last = 0;
    private NestedScrollView _nsScroll;
    private boolean _end = false;
    private int hour;
    private int total = 0;
    private ArrayList<Foods> Canteenfood = new ArrayList<Foods>();
    private ArrayList<String> values = new ArrayList<String>();
    private boolean isLoading = false;
    private boolean _first = false;
    private Handler handler;
    private int currentPage = PAGE_START;
    private boolean isLastPage = false;
    private int totalPage = 10;
    private int quotient, remainder;
    private int actual = 10;
    private ArrayList<String> MenuArray = new ArrayList<String>();
    private ArrayList<_menu> CanteenArray = new ArrayList<_menu>();
    private All_fragment_adapter sAdapter;
    private LinearLayoutManager mHorizontal;
    private TextView orders, _description;
    private ImageView _i4, _arrow;
    private SwipeRefreshLayout mSwipeRefreshLayout;
    private NetworkImageView service_pic;
    private Toolbar toolbar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.tez_canteen_details);
        cd = new ConnectionDetector(getApplicationContext());
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        progressBar = findViewById(R.id.progressBar3_eats);
        coordinatorLayout = findViewById(R.id.main_content);
        handler = new Handler();
        _moreRv = findViewById(R.id.moreRv);
        _moreRv.setNestedScrollingEnabled(false);
        service_pic = findViewById(R.id.service_pic);
        _description=findViewById(R.id._description);
        _i4 = findViewById(R.id._i4);
        _i4.setOnClickListener(this);
        toolbar = findViewById(R.id.toolbardd);
        setSupportActionBar(toolbar);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        toolbar.setTitle(R.string.app_name);


        orders = findViewById(R.id.orders);

        if (pref.get_food_items() != 0) {
            orders.setText(String.valueOf(pref.get_food_items()));

        }

        mSwipeRefreshLayout = findViewById(R.id.swipeToRefresh);
        mSwipeRefreshLayout.setColorSchemeResources(R.color.colorAccent);


        mHorizontal = new LinearLayoutManager(Canteen_Details.this, LinearLayoutManager.VERTICAL, false);
        _moreRv.setLayoutManager(mHorizontal);

        if (pref.getCancel1() != null) {
            String url = pref.getCancel1().replaceAll(" ", "%20");
            ImageLoader imageLoader = LruBitmapCache.getInstance(Canteen_Details.this)
                    .getImageLoader();
            imageLoader.get(url, ImageLoader.getImageListener(service_pic,
                    R.mipmap.ic_launcher, R.mipmap
                            .ic_launcher));
            service_pic.setImageUrl(url, imageLoader);
            Log.e("pref.getCancel5()", String.valueOf(pref.getCancel5()));
            _description.setText(pref.getCancel5());
        }


        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(Canteen_Details.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

            }
        });
    }


    @Override
    protected void onResume() {
        super.onResume();
        mSwipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                go();
                mSwipeRefreshLayout.setRefreshing(true);
            }
        });
        go();

    }


    private void go() {
        CanteenArray.clear();
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_FOODSS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        Log.e("2nd", response);
                        try {

                            JSONObject jsonObj = new JSONObject(response);
                            JSONArray Eat = jsonObj.getJSONArray("foods");
                            if (Eat.length() != 0) {
                                for (int i = 0; i < Eat.length(); i++) {
                                    JSONObject d = Eat.getJSONObject(i);
                                    if (!d.isNull("Name")) {
                                        if (pref.getID1() == 1) {
                                            MenuArray.add(d.getString("Submenu"));
                                        } else {
                                            MenuArray.add(d.getString("Menu"));
                                        }
                                        _menu item = new _menu();
                                        item.setID(d.getInt("ID"));
                                        item.setName(d.getString("Name"));
                                        item.setPrice(d.getDouble("MeatExpressPrice") - d.getDouble("Discount"));
                                        item.seteTEZ_Price(d.getDouble("MeatExpressPrice"));
                                        item.setPhoto(d.getString("Photo"));
                                        item.setDiscount(d.getDouble("Discount"));
                                        item.setSubsubmenu(d.getString("Subsubmenu"));
                                        item.setSubmenu(d.getString("Submenu"));
                                        item.setMenu(d.getString("Menu"));
                                        item.setDetails(d.getString("Description"));
                                        CanteenArray.add(item);

                                    }
                                }

                            }


                        } catch (final JSONException e) {
                            Log.e("HI", "Json parsing error: " + e.getMessage());


                        }


                        populate();


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
                params.put("_mId", String.valueOf(1));
                params.put("menu", String.valueOf(pref.getFrom1()));
                params.put("food", String.valueOf(pref.getFrom2()));
                return params;
            }

        };
        eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        AppController.getInstance().addToRequestQueue(eventoReq);

    }


    private void populate() {


        if (CanteenArray.size() != 0) {
          /*  Set<String> set = new HashSet<>(MenuArray);
            MenuArray.clear();
            MenuArray.addAll(set);
            sAdapter = new All_fragment_adapter(Canteen_Details.this, MenuArray);
            sAdapter.notifyDataSetChanged();
            sAdapter.setPref(pref);
            sAdapter.setCoordinatorlayout(coordinatorLayout);
            sAdapter.setHasStableIds(true);
            sAdapter.setFrom(1);
            sAdapter.setValues(orders);
            _moreRv.setVisibility(View.VISIBLE);
            _moreRv.setItemAnimator(new DefaultItemAnimator());
            _moreRv.setAdapter(sAdapter);
            _moreRv.setHasFixedSize(true);*/
            if (pref.get_food_items() != 0) {
                orders.setText(String.valueOf(pref.get_food_items()));
            } else {
                orders.setText(String.valueOf(0));
            }

            secondadapter hadapter = new secondadapter(Canteen_Details.this, CanteenArray);
            LinearLayoutManager mHorizontal = new LinearLayoutManager(Canteen_Details.this, LinearLayoutManager.VERTICAL, false);
            hadapter.notifyDataSetChanged();
            hadapter.setPref(pref);
            hadapter.setValues(orders);
            _moreRv.setVisibility(View.VISIBLE);
            _moreRv.setItemAnimator(new DefaultItemAnimator());
            _moreRv.setAdapter(hadapter);
            _moreRv.setLayoutManager(mHorizontal);
            mSwipeRefreshLayout.setRefreshing(false);
        } else {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "No item found in category " + pref.getcName() + " .Please visit later.", Snackbar.LENGTH_INDEFINITE)
                    .setAction("Back", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            Intent i = new Intent(Canteen_Details.this, Canteen_Mainactivity.class);
                            i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                            startActivity(i);
                            finish();
                            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                        }
                    });
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();
        }


    }


    @Override
    public void onClick(View v) {

        switch (v.getId()) {
            case R.id._i4:
                if (_phoneNo != null) {
                    if (pref.get_food_items() != 0) {
                        pref.set_cID1(2);
                        if(pref.getUniqueRide()==null) {
                            Intent o = new Intent(Canteen_Details.this, MapActivity.class);
                            pref.set_ride(4);
                            startActivity(o);
                            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                        }else{
                            Intent o = new Intent(Canteen_Details.this, GooglemapApp.class);
                            pref.set_ride(4);
                            startActivity(o);
                            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                        }
                    } else {
                        if (!Canteen_Details.this.isFinishing()) {
                            new AlertDialog.Builder(Canteen_Details.this, R.style.AlertDialogTheme)
                                    .setTitle("Your cart is empty")
                                    .setMessage("Please add items to your cart.")
                                    .setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                            Intent o = new Intent(Canteen_Details.this, Canteen_Mainactivity.class);
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
                    if (!Canteen_Details.this.isFinishing()) {
                        new AlertDialog.Builder(Canteen_Details.this, R.style.AlertDialogTheme)
                                .setTitle("Please login.")
                                .setMessage("You need to login to complete your order.")
                                .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(Canteen_Details.this, ServiceOffer.class);

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
                break;


            default:
                break;
        }
    }


    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent i = new Intent(Canteen_Details.this, Canteen_Mainactivity.class);
            startActivity(i);
            finish();
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
        }
        return true;
    }

    @Override
    protected void onStart() {
        super.onStart();

    }

    @Override
    public void onPause() {

        super.onPause();
    }

    @Override
    protected void onStop() {
        super.onStop();

    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        Log.w("DES", "DES");
    }

}






