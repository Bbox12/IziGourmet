package com.liteafrica.izigourmet.Activites.Main_Page;

import android.app.Activity;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.PorterDuff;
import android.graphics.drawable.LayerDrawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.RatingBar;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

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
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.liteafrica.izigourmet.Activites.Splash_screen;
import com.liteafrica.izigourmet.Adapters.BookingAdapter;
import com.liteafrica.izigourmet.Model.Foods;
import com.liteafrica.izigourmet.Model.Remarks;
import com.liteafrica.izigourmet.Model.User;
import com.liteafrica.izigourmet.R;
import com.squareup.picasso.Picasso;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.net.UnknownHostException;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;

public class UserSuccess extends AppCompatActivity implements View.OnClickListener {


    DecimalFormat df = new DecimalFormat("0.00");
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _PhoneNo;
    private DatabaseReference mDatabase;
    private String User_pic;
    private float rate = 0.0f;
    private String Rate_user;
    private double My_lat = 0, My_long = 0;
    private Toolbar toolbar;
    private RatingBar ratedriver;
    private ImageView DriverImage;
    private Button Stop;
    private TextView S1, S2;
    private TextView _bill_generated;
    private ProgressBar _p1;
    private String _Name;
    private Button Bill;
    private TextView _name,t12;
    private String Total_cost, Raw_cost, Coupon_discount, Tax_amount;
    private CoordinatorLayout coordinatorLayout;
    private String Cost;
    private ArrayList<Remarks> mRemarks = new ArrayList<Remarks>();
    private TextView discountprice_1;
    private double pCost = 0;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.usersuccess);
        _bill_generated = findViewById(R.id.bill_generated);
        ratedriver = findViewById(R.id.ratingBarbill);
        LayerDrawable stars = (LayerDrawable) ratedriver.getProgressDrawable();
        stars.getDrawable(2).setColorFilter(Color.YELLOW, PorterDuff.Mode.SRC_ATOP);
        DriverImage = findViewById(R.id.driver_bill);
        Stop = findViewById(R.id.success_ride);
        S1 = findViewById(R.id.s1);
        S2 = findViewById(R.id.s2);
        S1.setText("Your Order");
        S2.setText(" Delivered");
        coordinatorLayout = findViewById(R.id.success_);
        Bill = findViewById(R.id.button_bill);
        Bill.setOnClickListener(this);
        toolbar = findViewById(R.id.toolbar_success);
        _p1 = findViewById(R.id.p1);
        setSupportActionBar(toolbar);
        _name = findViewById(R.id._name);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        mDatabase = FirebaseDatabase.getInstance().getReference();

        discountprice_1 = findViewById(R.id.discountprice_1);
        t12=findViewById(R.id.t12);

        Stop.setOnClickListener(this);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(UserSuccess.this, Splash_screen.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);
            }
        });

        if(pref.getGoTRide()==1){
            DriverImage.setVisibility(View.GONE);
            _name.setVisibility(View.GONE);
            t12.setText("How was your experience?");
        }

        if (pref.getDriverimage() != null) {
            Picasso
                    .with(UserSuccess.this)
                    .load(pref.getDriverimage())
                    .resize(72, 72)
                    .centerInside() // resizes the image to these dimensions (in pixel). does not respect aspect ratio
                    .into(DriverImage);
        }

        if (pref.getDriverName() != null) {
            _name.setText(pref.getDriverName());
        }
    }

    @Override
    protected void onPause() {
        super.onPause();

    }

    @Override
    protected void onDestroy() {

        super.onDestroy();
    }

    @Override
    protected void onResume() {
        super.onResume();
        ratedriver.setOnRatingBarChangeListener(new RatingBar.OnRatingBarChangeListener() {
            @Override
            public void onRatingChanged(RatingBar ratingBar, float v, boolean b) {
                Rate_user = String.valueOf(v);
                rate = v;
                mRemarks = new ArrayList<Remarks>();
                _p1.setVisibility(View.VISIBLE);

            }
        });

        if (pref.getUniqueRide() != null) {
            new GetRide().execute();
        }

    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {

            case R.id.button_bill:
                if (!UserSuccess.this.isFinishing()) {
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
                                                    mItems.add(items);
                                                }
                                            }

                                        }


                                    } catch (final JSONException e) {
                                        Log.e("HI", "Json parsing error: " + e.getMessage());


                                    }


                                    final Dialog dialog = new Dialog(UserSuccess.this, R.style.AlertDialogTheme);

                                    dialog.setCancelable(true);
                                    dialog.setCanceledOnTouchOutside(true);
                                    dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
                                    dialog.setContentView(R.layout.dialog_bill);

                                    DecimalFormat dft = new DecimalFormat("0.00");

                                    RecyclerView _moreRv = dialog.findViewById(R.id.moreRvs);
                                    _moreRv.setNestedScrollingEnabled(false);
                                    TextView _moneyValue = dialog.findViewById(R.id.canteen_amounts);
                                    TextView _itemValue = dialog.findViewById(R.id._noofItemss);
                                    TextView _discount = dialog.findViewById(R.id.discounts);
                                    TextView _tAmount = dialog.findViewById(R.id._tamounts);
                                    TextView _dAmount = dialog.findViewById(R.id._damounts);
                                    TextView dst = dialog.findViewById(R.id.dst);
                                    TextView _payAmount = dialog.findViewById(R.id._payamounts);
                                    TextView pmode = dialog.findViewById(R.id.pmode);
                                    pmode.setVisibility(View.VISIBLE);

                                    int Rate = 0;

                                    _moreRv.setVisibility(View.VISIBLE);
                                    BookingAdapter sAdapter1 = new BookingAdapter(UserSuccess.this, mUser);
                                    sAdapter1.notifyDataSetChanged();
                                    sAdapter1.setPref(pref);
                                    sAdapter1.setFrom(1);
                                    LinearLayoutManager mLayoutManager = new LinearLayoutManager(UserSuccess.this, LinearLayoutManager.VERTICAL, false);
                                    _moreRv.setLayoutManager(mLayoutManager);
                                    _moreRv.setItemAnimator(new DefaultItemAnimator());
                                    _moreRv.setAdapter(sAdapter1);
                                    _moreRv.setHasFixedSize(true);
                                    _tAmount.setText("R" + df.format(Rate));


                                    if (mItems.size() != 0) {


                                        // DecimalFormat dft=new DecimalFormat("0.00");
                                        if (mItems.get(0).getCost(0) != null && !mItems.get(0).getCost(0).contains("null")) {
                                            _payAmount.setText("R" + mItems.get(0).getCost(0));
                                            if (Double.parseDouble(mItems.get(0).getpCost(0)) != 0) {
                                                _tAmount.setText("R" + mItems.get(0).getpCost(0));
                                                double d = Double.parseDouble(mItems.get(0).getpCost(0)) - Double.parseDouble(mItems.get(0).getCost(0));
                                                _dAmount.setText("R" + "-" + dft.format(d));
                                            } else {
                                                _tAmount.setText("R" + mItems.get(0).getCost(0));
                                            }
                                            _moneyValue.setVisibility(View.GONE);
                                            _itemValue.setVisibility(View.GONE);
                                            dst.setVisibility(View.GONE);
                                        }


                                        if (mItems.get(0).getPaymentMode(0) == 1) {
                                            if (mItems.get(0).getIs_Paid(0) == 1) {
                                                pmode.setText("COD, PAID");
                                            }

                                        } else if (mItems.get(0).getPaymentMode(0) == 2) {
                                            if (mItems.get(0).getPaymentVerified(0) == 0) {
                                                pmode.setText("EFT PAYMENT PENDING");
                                            } else {
                                                pmode.setText("EFT PAYMENT DONE");
                                            }
                                        }
                                        if (mItems.get(0).getPaymentMode(0) == 0) {

                                            pmode.setText("PAYMENT NOT SELECTEC");

                                        }

                                    }
                                    dialog.show();


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
                            params.put("submenu", pref.getOrder());
                            return params;
                        }

                    };
                    eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                            3000,
                            DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                            DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
                    com.liteafrica.izigourmet.AppController.getInstance().addToRequestQueue(eventoReq);
                }


                break;


            case R.id.success_ride:
                checkEmail();
                break;
            default:
                break;
        }
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();


    }

    private void checkEmail() {
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.URL_STORE_RATING,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {
                            if (!UserSuccess.this.isFinishing()) {
                                new AlertDialog.Builder(UserSuccess.this, R.style.AlertDialogTheme)
                                        .setIcon(R.mipmap.ic_launcher)
                                        .setTitle("Thank you")
                                        .setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                                            @Override
                                            public void onClick(DialogInterface dialog, int which) {
                                                pref.set_ride(0);
                                                pref.set_cID(0);
                                                pref.packagesharedPreferences(null);
                                                pref.setPickAt1(null);
                                                pref.setDropAt1(null);
                                                pref.set_food_money(0);
                                                pref.set_food_items(0);
                                                pref.setPickLat1(null);
                                                pref.setPickLong1(null);
                                                pref.setCanteen(null);
                                                pref.setcName(null);
                                                pref.setcPhoto(null);
                                                pref.setcAddress(null);
                                                pref.setcDiscount(0);
                                                pref.setcPackaging(0);
                                                pref.setcLess(null);
                                                pref.setcMore(null);
                                                pref.setDelivery(0);
                                                pref.setGoTRide(0);
                                                pref.setTotal(null);
                                                pref.setTotal2(null);
                                                pref.setadTetxt(null);
                                                pref.setPayment(0);
                                                String[] pars = pref.getUniqueRide().split("\\.");
                                                String con = TextUtils.join("", pars);
                                                pref.setUniqueRide(null);
                                                mDatabase.child("IziGourmet").child(con).removeValue();
                                                if (pref.getDriverPhone() != null) {
                                                    mDatabase.child("Driver_Online").child(pref.getDriverPhone()).child("Ride").removeValue();
                                                }
                                                Intent i = new Intent(UserSuccess.this, Splash_screen.class);
                                                startActivity(i);
                                                finish();
                                                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                                dialog.cancel();
                                            }
                                        })
                                        .show();

                            }

                        } else {
                            ViewDialogFailed alert = new ViewDialogFailed();
                            alert.showDialog(UserSuccess.this, "Please check the information provided!", true);
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
                params.put("unique", pref.getUniqueRide());
                params.put("rating", String.valueOf(ratedriver.getRating()));
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

    private class GetRide extends AsyncTask<Void, Integer, String> {

        private String Cost;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            _p1.setVisibility(View.VISIBLE);
        }

        protected String doInBackground(Void... args) {
            return uploadFile();
        }

        private String uploadFile() {
            // TODO Auto-generated method stub
            String res = null;

            try {


                RequestBody requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("_mId", _PhoneNo)
                        .addFormDataPart("Unique_Ride_Code", pref.getUniqueRide())
                        .build();

                Request request = new Request.Builder()
                        .url(com.liteafrica.izigourmet.Config_URL.GET_DETAILS_RIDES)
                        .post(requestBody)
                        .build();
                OkHttpClient client = new OkHttpClient();
                okhttp3.Response response = client.newCall(request).execute();
                res = response.body().string();
                try {
                    JSONObject jsonObj = new JSONObject(res);

                    JSONArray ride = jsonObj.getJSONArray("Book_Ride_Now");
                    for (int i = 0; i < ride.length(); i++) {
                        JSONObject c = ride.getJSONObject(i);
                        if (!c.isNull("Cost")) {
                            Cost = c.getString("Cost");
                            pCost = c.getDouble("pCost");

                        }
                    }


                } catch (final JSONException e) {
                    Log.e("TAG", "Error: " + e.getLocalizedMessage());
                }

                Log.e("TAG", "Response : " + res);

                return res;

            } catch (UnknownHostException | UnsupportedEncodingException e) {
                Log.e("TAG", "Error: " + e.getLocalizedMessage());
            } catch (Exception e) {
                Log.e("TAG", "Other Error: " + e.getLocalizedMessage());
                // new GetRide().execute();
            }


            return res;

        }

        protected void onPostExecute(String file_url) {
            _p1.setVisibility(View.GONE);
            _bill_generated.setText(Cost);
            if (pCost == 0 || pCost == Double.parseDouble(Cost)) {
                discountprice_1.setVisibility(View.GONE);
            } else {
                discountprice_1.setVisibility(View.VISIBLE);
                discountprice_1.setText(String.valueOf(pCost));
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
}
