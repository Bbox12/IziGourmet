package com.liteafrica.izigourmet.Activites.Canteen;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.net.Uri;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.core.widget.NestedScrollView;
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
import com.google.android.material.appbar.CollapsingToolbarLayout;
import com.google.android.material.snackbar.Snackbar;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.Login.ServiceOffer;
import com.liteafrica.izigourmet.LruBitmapCache;
import com.liteafrica.izigourmet.Model._menu;
import com.liteafrica.izigourmet.R;
import com.squareup.picasso.Picasso;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import java.util.Set;

public class SingleProduct extends AppCompatActivity implements View.OnClickListener {
    private NetworkImageView service_pic;
    private TextView _name1,  _description, discount_1, price_1, discountprice_1, rate_km1;
    private ImageButton button2_add1, button2_minus1;
    private CoordinatorLayout cor_home_eats;
    private ImageView _i4, _arrow;
    private TextView orders,flavour,slide;;
    private int _from = 0;
    private RecyclerView moreRv;
    private LinearLayout _L1;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _phoneNo;
    private CoordinatorLayout coordinatorLayout;
    private int itemSelected = 0;
    private double _orderValue = 0;
    private DecimalFormat df = new DecimalFormat("0.00");
    private ArrayList<String> _foods = new ArrayList<String>();
    private ArrayList<String> MenuArray = new ArrayList<String>();
    private ArrayList<_menu> CanteenArray = new ArrayList<_menu>();
    private ShimmerFrameLayout mShimmerViewContainer;
    private int _cost = 0;
    private NestedScrollView Nscroll;
    private Toolbar toolbar;
    private AppBarLayout appBarLayout;
    private LinearLayout L1;
    private SwipeRefreshLayout mSwipeRefreshLayout;
    private int Stock = 0;
    private TextView outofstock,T1;
    private LinearLayout rrr,view_pager;
    private ImageView Image1,Image2,Image3;
    private View V1,V2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.singleproduct);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
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
        _description = findViewById(R.id._description);
        discount_1 = findViewById(R.id.discount_1);
        price_1 = findViewById(R.id.price_1);
        discountprice_1 = findViewById(R.id.discountprice_1);
        rate_km1 = findViewById(R.id.rate_km1);
        button2_add1 = findViewById(R.id.button2_add1);
        button2_minus1 = findViewById(R.id.button2_minus1);
        _i4 = findViewById(R.id._i4);
        _i4.setOnClickListener(this);
        orders = findViewById(R.id.orders);

        rrr = findViewById(R.id._rrr1);
        outofstock = findViewById(R.id.outofstock);

        Image1=findViewById(R.id.image_1);
        Image2=findViewById(R.id.image_2);
        Image3=findViewById(R.id.image_3);

        V1 = findViewById(R.id.V1);
        V2 = findViewById(R.id.V2);

        flavour = findViewById(R.id.flavour);
        slide = findViewById(R.id.slide);

        view_pager=findViewById(R.id.view_pager);


       T1=findViewById(R.id.T1);


        if (pref.get_food_items() != 0) {
            orders.setText(String.valueOf(pref.get_food_items()));

        }
        mSwipeRefreshLayout = findViewById(R.id.swipeToRefresh);
        mSwipeRefreshLayout.setColorSchemeResources(R.color.colorAccent);

        coordinatorLayout = findViewById(R.id.cor_home_eats);
        button2_minus1.setOnClickListener(this);
        button2_add1.setOnClickListener(this);


        Nscroll = findViewById(R.id.Nscroll);


        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            }
        });
    }


    private void initCollapsingToolbar(final String name) {
        final CollapsingToolbarLayout collapsingToolbar =
                findViewById(R.id.toolbar_layout);


        appBarLayout = findViewById(R.id.app_bar_main);
        appBarLayout.addOnOffsetChangedListener(new AppBarLayout.OnOffsetChangedListener() {
            boolean isShow = false;
            int scrollRange = -1;

            @Override
            public void onOffsetChanged(AppBarLayout appBarLayout, int verticalOffset) {
                if (scrollRange == -1) {
                    scrollRange = appBarLayout.getTotalScrollRange();
                }
                if (scrollRange + verticalOffset == 0) {
                    collapsingToolbar.setCollapsedTitleGravity(Gravity.LEFT);
                    isShow = true;
                    collapsingToolbar.setTitleEnabled(false);
                    getSupportActionBar().setDisplayShowTitleEnabled(true);
                    toolbar.setTitle(name);

                } else if (isShow) {
                    collapsingToolbar.setTitleEnabled(false);
                    toolbar.setVisibility(View.VISIBLE);
                    getSupportActionBar().setDisplayShowTitleEnabled(false);
                    isShow = false;
                    LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                            LinearLayout.LayoutParams.WRAP_CONTENT,
                            LinearLayout.LayoutParams.WRAP_CONTENT
                    );
                    params.setMargins(0, 0, 0, 0);

                }
            }
        });

    }


    @Override
    public void onClick(View v) {

        switch (v.getId()) {

            case R.id.button2_add1:
                if (pref.getUniqueRide() == null) {
                    if (_cost != 0) {
                        boolean _again = false;
                        int Rate_ = Integer.parseInt(rate_km1.getText().toString());
                        Rate_ = 1 + Rate_;
                        int dk = _cost;
                        _orderValue = pref.get_food_money() + dk;
                        pref.set_food_money((float) _orderValue);
                        rate_km1.setText(String.valueOf(Rate_));
                        if (pref.get_packagesharedPreferences() != null) {
                            Set<String> set = pref.get_packagesharedPreferences();
                            _foods.clear();
                            _foods.addAll(set);
                        }
                        for (int i = 0; i < _foods.size(); i++) {
                            String[] pars = _foods.get(i).split("\\^");
                            if (pref.getID5() == Integer.parseInt(pars[0])) {
                                String s = pars[0];
                                _foods.remove(i);
                                _again = true;
                                _foods.add(s + "^" + Rate_ + "^" + Rate_ * dk + "^" + _name1.getText().toString() + "^" + 1);
                            }

                        }
                        if (!_again) {
                            itemSelected = pref.get_food_items();
                            itemSelected = itemSelected + 1;
                            pref.set_food_items(itemSelected);
                            _foods.add(pref.getID5() + "^" + 1 + "^" + dk + "^" + _name1.getText().toString() + "^" + 1);
                        }
                        pref.packagesharedPreferences(_foods);
                        orders.setText(String.valueOf(pref.get_food_items()));

                    }
                } else {
                    if (!SingleProduct.this.isFinishing()) {
                        new AlertDialog.Builder(SingleProduct.this, R.style.AlertDialogTheme)
                                .setTitle("Your order is already in process")
                                .setMessage("Please check the status of your order")
                                .setPositiveButton("Check", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(SingleProduct.this, GooglemapApp.class);
                                        startActivity(o);
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
            case R.id.button2_minus1:
                if (pref.getUniqueRide() == null) {
                    if (_cost != 0) {
                        int Rate_2 = Integer.parseInt(rate_km1.getText().toString());
                        if (Rate_2 > 0) {
                            Rate_2 = Rate_2 - 1;
                            rate_km1.setText(String.valueOf(Rate_2));
                            int jk = _cost;
                            _orderValue = pref.get_food_money() - jk;
                            pref.set_food_money((float) _orderValue);
                            if (pref.get_packagesharedPreferences() != null) {
                                Set<String> set = pref.get_packagesharedPreferences();
                                _foods.clear();
                                _foods.addAll(set);
                            }
                            for (int i = 0; i < _foods.size(); i++) {
                                String[] pars = _foods.get(i).split("\\^");
                                if (pref.getID5() == Integer.parseInt(pars[0])) {
                                    String s = pars[0];
                                    _foods.remove(i);
                                    _foods.add(s + "^" + Rate_2 + "^" + Rate_2 * jk + "^" + _name1.getText().toString() + "^" + 1);

                                }

                            }
                            pref.packagesharedPreferences(_foods);
                        }

                        if (Rate_2 == 0) {
                            rate_km1.setText("0");
                            for (int i = 0; i < _foods.size(); i++) {
                                String[] pars = _foods.get(i).split("\\^");
                                if (pref.getID5() == Integer.parseInt(pars[0])) {
                                    _foods.remove(i);

                                    itemSelected = pref.get_food_items();
                                    itemSelected = itemSelected - 1;
                                    pref.set_food_items(itemSelected);
                                    orders.setText(String.valueOf(pref.get_food_items()));
                                }

                            }
                            pref.packagesharedPreferences(_foods);
                            if (itemSelected == 0) {
                                pref.packagesharedPreferences(null);
                                pref.set_food_money(0);
                                pref.set_food_items(0);
                                pref.setTotal(null);
                                pref.setTotal2(null);
                            }
                        }

                    }
                } else {
                    if (!SingleProduct.this.isFinishing()) {
                        new AlertDialog.Builder(SingleProduct.this, R.style.AlertDialogTheme)
                                .setTitle("Your order is already in process")
                                .setMessage("Please check the status of your order")
                                .setPositiveButton("Check", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(SingleProduct.this, GooglemapApp.class);

                                        startActivity(o);
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

            case R.id._i4:
                if (_phoneNo != null) {
                    if (pref.get_food_items() != 0) {
                        pref.set_cID1(2);
                        Intent o = new Intent(SingleProduct.this, GooglemapApp.class);
                        startActivity(o);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                    } else {
                        if (!SingleProduct.this.isFinishing()) {
                            new AlertDialog.Builder(SingleProduct.this, R.style.AlertDialogTheme)
                                    .setTitle("Your cart is empty")
                                    .setMessage("Please add items to your cart.")
                                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                            Intent o = new Intent(SingleProduct.this, Canteen_Mainactivity.class);
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
                    if (!SingleProduct.this.isFinishing()) {
                        new AlertDialog.Builder(SingleProduct.this, R.style.AlertDialogTheme)
                                .setTitle("Please login.")
                                .setMessage("You need to login to complete your order.")
                                .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(SingleProduct.this, ServiceOffer.class);

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

                Intent i = new Intent(SingleProduct.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

                break;

        }

    }

    @Override
    protected void onResume() {
        super.onResume();
        if (pref.getPref2() == 1) {
            pref.setPref2(0);
            checkSingleProduct();
        }
        mSwipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                checkSingleProduct();
                mSwipeRefreshLayout.setRefreshing(true);
            }
        });

        if (pref.get_packagesharedPreferences() != null) {
            Set<String> set = pref.get_packagesharedPreferences();
            _foods.clear();
            _foods.addAll(set);
            for (String s : set) {
                String[] pars = s.split("\\^");
                if (Integer.parseInt(pars[0]) == pref.getID5()) {
                    rate_km1.setText(pars[1]);
                    break;
                }
            }
        }

        if (pref.get_food_items() != 0) {
            _orderValue = pref.get_food_money();
            pref.set_food_money((float) _orderValue);

        } else {
            pref.set_food_money(0);
        }


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

    private void checkSingleProduct() {

        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.URL_GET_ID,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.e("deatails", response);

                        JSONObject jsonObj = null;
                        try {
                            jsonObj = new JSONObject(response);
                            JSONArray login = jsonObj.getJSONArray("bookingservices");
                            for (int i = 0; i < login.length(); i++) {
                                JSONObject c = login.getJSONObject(i);
                                if (!c.isNull("ID")) {
                                    _name1.setText(c.getString("Name"));

                                    if(!TextUtils.isEmpty(c.getString("Description"))){
                                        _description.setText(c.getString("Description"));
                                    }else{
                                        T1.setVisibility(View.GONE);
                                        _description.setVisibility(View.GONE);
                                    }

                                    discountprice_1.setText("R" + df.format(c.getDouble("JalpanPrice")));
                                    if (c.getDouble("Discount") != 0) {
                                        discount_1.setText("R" + df.format(c.getDouble("Discount")) + " off");
                                    } else {
                                        discount_1.setVisibility(View.GONE);
                                        discountprice_1.setVisibility(View.GONE);
                                        V1.setVisibility(View.GONE);
                                        V2.setVisibility(View.GONE);
                                    }
                                    _cost = (int) (c.getDouble("JalpanPrice") - c.getDouble("Discount"));
                                    price_1.setText("R" + df.format(_cost));
                                    price_1.setTextColor(Color.BLACK);
                                    Stock = c.getInt("Unit");
                                    String url = c.getString("Photo").replaceAll(" ", "%20");
                                    ImageLoader imageLoader = LruBitmapCache.getInstance(SingleProduct.this)
                                            .getImageLoader();
                                    imageLoader.get(url, ImageLoader.getImageListener(service_pic,
                                            R.mipmap.ic_launcher, R.mipmap
                                                    .ic_launcher));
                                    service_pic.setImageUrl(url, imageLoader);
                                    mShimmerViewContainer.stopShimmerAnimation();
                                    mShimmerViewContainer.setVisibility(View.GONE);




                                    if (c.getString("Subsubmenu") != null && !TextUtils.isEmpty(c.getString("Subsubmenu") ) && !c.getString("Subsubmenu") .contains("null")) {
                                        flavour.setText(c.getString("Subsubmenu") );
                                    } else {
                                        flavour.setVisibility(View.GONE);

                                    }



                                    if (c.getString("Submenu")  != null && !TextUtils.isEmpty(c.getString("Submenu")) && !c.getString("Submenu").contains("null")) {
                                        slide.setText(c.getString("Submenu"));
                                    } else {
                                       slide.setVisibility(View.GONE);

                                    }

                                    if(!TextUtils.isEmpty(c.getString("Photo1"))){
                                        String url2 = c.getString("Photo1").replaceAll(" ", "%20");
                                        Picasso.Builder builder = new Picasso.Builder(SingleProduct.this);
                                        builder.listener(new Picasso.Listener() {
                                            @Override
                                            public void onImageLoadFailed(Picasso picasso, Uri uri, Exception exception) {
                                                exception.printStackTrace();
                                            }
                                        });
                                        builder.build().load(url2).into(Image1);
                                    }

                                    if(!TextUtils.isEmpty(c.getString("Photo2"))){
                                        String url3 = c.getString("Photo2").replaceAll(" ", "%20");
                                        Picasso.Builder builder = new Picasso.Builder(SingleProduct.this);
                                        builder.listener(new Picasso.Listener() {
                                            @Override
                                            public void onImageLoadFailed(Picasso picasso, Uri uri, Exception exception) {
                                                exception.printStackTrace();
                                            }
                                        });
                                        builder.build().load(url3).into(Image2);
                                    }
                                    if(!TextUtils.isEmpty(c.getString("Photo3"))){
                                        String url3 = c.getString("Photo3").replaceAll(" ", "%20");
                                        Picasso.Builder builder = new Picasso.Builder(SingleProduct.this);
                                        builder.listener(new Picasso.Listener() {
                                            @Override
                                            public void onImageLoadFailed(Picasso picasso, Uri uri, Exception exception) {
                                                exception.printStackTrace();
                                            }
                                        });
                                        builder.build().load(url3).into(Image3);
                                    }else{
                                        view_pager.setVisibility(View.GONE);
                                    }
                                    mSwipeRefreshLayout.setRefreshing(false);
                                    if(c.getInt("isOutOfStock")==0) {
                                        if (Stock == 0) {
                                            rrr.setVisibility(View.GONE);
                                            outofstock.setVisibility(View.VISIBLE);
                                        } else {
                                            rrr.setVisibility(View.VISIBLE);
                                            outofstock.setVisibility(View.GONE);
                                        }
                                    }else{
                                        rrr.setVisibility(View.GONE);
                                        outofstock.setVisibility(View.VISIBLE);
                                    }
                                    rrr.setVisibility(View.VISIBLE);
                                    outofstock.setVisibility(View.GONE);
                                    initCollapsingToolbar(c.getString("Name"));
                                }
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
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
                params.put("ID", String.valueOf(pref.getID5()));
                return params;
            }

        };

        eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                3000,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        AppController.getInstance().addToRequestQueue(eventoReq);

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
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
        }
        return true;
    }

}
