package com.liteafrica.izigourmet.Activites.Canteen;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.core.widget.NestedScrollView;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
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
import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.android.volley.toolbox.StringRequest;
import com.facebook.shimmer.ShimmerFrameLayout;
import com.google.android.material.appbar.AppBarLayout;
import com.google.android.material.snackbar.Snackbar;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.Adapters.All_fragment_adapter;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.Config_URL;
import com.liteafrica.izigourmet.Login.ServiceOffer;
import com.liteafrica.izigourmet.LruBitmapCache;
import com.liteafrica.izigourmet.Model._menu;
import com.liteafrica.izigourmet.PrefManager;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Map;
import java.util.Set;

public class ProductDetailsPage extends AppCompatActivity implements View.OnClickListener {
    private NetworkImageView service_pic;
    private TextView _name1, _details1, _description;
    private ImageView _i4, _arrow;
    private TextView orders, _address;
    private int _from = 0;
    private RecyclerView moreRv;
    private PrefManager pref;
    private String _phoneNo;
    private CoordinatorLayout coordinatorLayout;
    private DecimalFormat df = new DecimalFormat("0.00");
    private ArrayList<String> _foods = new ArrayList<String>();
    private ArrayList<String> MenuArray = new ArrayList<String>();
    private ArrayList<_menu> CanteenArray = new ArrayList<_menu>();
    private ShimmerFrameLayout mShimmerViewContainer;
    private int _cost = 0;
    private NestedScrollView Nscroll;
    private Toolbar toolbar;
    private AppBarLayout appBarLayout;
    private SwipeRefreshLayout mSwipeRefreshLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.productdetailspage);
        pref = new PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(PrefManager.KEY_MOBILE);
        mShimmerViewContainer = findViewById(R.id.shimmer_view_container);
        mShimmerViewContainer.setVisibility(View.VISIBLE);
        mShimmerViewContainer.startShimmerAnimation();

        toolbar = findViewById(R.id.toolbardd);
        setSupportActionBar(toolbar);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        toolbar.setTitle(R.string.app_name);

        service_pic = findViewById(R.id.service_pic);
        _name1 = findViewById(R.id._name1);
        _details1 = findViewById(R.id._details1);
        _description = findViewById(R.id._description);
        _i4 = findViewById(R.id._i4);
        _i4.setOnClickListener(this);
        orders = findViewById(R.id.orders);

        _address = findViewById(R.id.address);
        if (pref.getDropAt() != null) {
            _address.setText(pref.getDropAt());
        }
        if (pref.get_food_items() != 0) {
            orders.setText(String.valueOf(pref.get_food_items()));

        }
        mSwipeRefreshLayout = findViewById(R.id.swipeToRefresh);
        mSwipeRefreshLayout.setColorSchemeResources(R.color.colorAccent);

        coordinatorLayout = findViewById(R.id.cor_home_eats);
        moreRv = findViewById(R.id.moreRv);
        moreRv.setNestedScrollingEnabled(false);


        Nscroll = findViewById(R.id.Nscroll);


        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
                overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);
            }
        });
    }


    @Override
    public void onClick(View v) {

        switch (v.getId()) {


            case R.id._i4:
                if (_phoneNo != null) {
                    if (pref.get_food_items() != 0) {
                        pref.set_cID1(2);
                        Intent o = new Intent(ProductDetailsPage.this, GooglemapApp.class);
                        startActivity(o);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                    } else {
                        if (!ProductDetailsPage.this.isFinishing()) {
                            new AlertDialog.Builder(ProductDetailsPage.this, R.style.AlertDialogTheme)
                                    .setTitle("Your cart is empty")
                                    .setMessage("Please add items to your cart.")
                                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                            Intent o = new Intent(ProductDetailsPage.this, Canteen_Mainactivity.class);
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
                    if (!ProductDetailsPage.this.isFinishing()) {
                        new AlertDialog.Builder(ProductDetailsPage.this, R.style.AlertDialogTheme)
                                .setTitle("Please login.")
                                .setMessage("You need to login to complete your order.")
                                .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(ProductDetailsPage.this, ServiceOffer.class);

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
            case R.id.arrow:

                Intent i = new Intent(ProductDetailsPage.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

                break;

        }

    }

    @Override
    protected void onResume() {
        super.onResume();
        mSwipeRefreshLayout.setRefreshing(true);
        checkMainProduct();
        mSwipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                checkMainProduct();
                mSwipeRefreshLayout.setRefreshing(true);
            }
        });

    }


    @Override
    public void onPause() {
        mShimmerViewContainer.stopShimmerAnimation();
        super.onPause();

    }

    @Override
    protected void onStop() {
        super.onStop();
        mShimmerViewContainer.stopShimmerAnimation();

    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }


    private void checkMainProduct() {

        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, Config_URL.URL_MAIN_PRODUCT,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);
                        JSONObject jsonObj = null;
                        try {
                            jsonObj = new JSONObject(response);
                            JSONArray login = jsonObj.getJSONArray("bookingservices");
                            for (int i = 0; i < login.length(); i++) {
                                JSONObject c = login.getJSONObject(i);
                                if (!c.isNull("ID")) {
                                    _name1.setText(c.getString("Name"));
                                    _details1.setText(c.getString("Specification"));
                                    _description.setText(c.getString("Description"));

                                    String url = c.getString("Photo").replaceAll(" ", "%20");
                                    ImageLoader imageLoader = LruBitmapCache.getInstance(ProductDetailsPage.this)
                                            .getImageLoader();
                                    imageLoader.get(url, ImageLoader.getImageListener(service_pic,
                                            R.mipmap.ic_launcher, R.mipmap
                                                    .ic_launcher));
                                    service_pic.setImageUrl(url, imageLoader);
                                }
                            }

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
                                        item.setSubmenu(d.getString("Submenu"));
                                        item.setMenu(d.getString("Menu"));
                                        item.setDetails(d.getString("Description"));
                                        item.setIsOutOfStock(d.getInt("isOutOfStock"));
                                        CanteenArray.add(item);
                                    }
                                }
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        mSwipeRefreshLayout.setRefreshing(false);
                        populate();
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
                params.put("ID", String.valueOf(pref.getID3()));
                return params;
            }

        };

        eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                3000,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        AppController.getInstance().addToRequestQueue(eventoReq);

    }


    private void populate() {

        if (mShimmerViewContainer.isAnimationStarted()) {
            mShimmerViewContainer.stopShimmerAnimation();
            mShimmerViewContainer.setVisibility(View.GONE);
        }

        if (MenuArray.size() != 0) {
            Set<String> set = new HashSet<>(MenuArray);
            MenuArray.clear();
            MenuArray.addAll(set);

            All_fragment_adapter sAdapter = new All_fragment_adapter(ProductDetailsPage.this, MenuArray);
            sAdapter.notifyDataSetChanged();
            sAdapter.setPref(pref);
            sAdapter.setCoordinatorlayout(coordinatorLayout);
            sAdapter.setHasStableIds(true);
            sAdapter.setValues(orders);
            moreRv.setVisibility(View.VISIBLE);
            moreRv.setItemAnimator(new DefaultItemAnimator());
            moreRv.setAdapter(sAdapter);
            moreRv.setHasFixedSize(true);
            LinearLayoutManager mHorizontal = new LinearLayoutManager(ProductDetailsPage.this, LinearLayoutManager.VERTICAL, false);
            moreRv.setLayoutManager(mHorizontal);
            if (pref.get_food_items() != 0) {
                orders.setText(String.valueOf(pref.get_food_items()));
            } else {
                orders.setText(String.valueOf(0));
            }

        } else {
            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "No item found in category " + pref.getcName() + " .Please visit later.", Snackbar.LENGTH_INDEFINITE)
                    .setAction("Back", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            Intent i = new Intent(ProductDetailsPage.this, Canteen_Mainactivity.class);
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
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            finish();
        }
        return true;
    }

}
