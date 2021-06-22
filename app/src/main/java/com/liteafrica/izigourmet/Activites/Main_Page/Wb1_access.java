package com.liteafrica.izigourmet.Activites.Main_Page;

import android.app.Activity;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkError;
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Activites.Canteen.SelectePaymentOption;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.PrefManager;
import com.liteafrica.izigourmet.R;

import java.util.HashMap;
import java.util.Map;


public class Wb1_access extends AppCompatActivity  {

    private WebView webView;
    private Toolbar toolbar;
    private String postUrl;
    private ProgressBar progressBar;
    private TextView orders;
    private ImageView _i4;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _PhoneNo;
    private int _from;
    private DatabaseReference mDatabase;
    private boolean first;
    private CoordinatorLayout coordinatorLayout;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent i = getIntent();
        postUrl = i.getStringExtra("url");
        _from = i.getIntExtra("from", 0);

        setContentView(R.layout.webb_access);

        webView = findViewById(R.id.webView);
        progressBar = findViewById(R.id.progressBar);
        webView.setWebViewClient(new CustomWebViewClient());
        WebSettings webSetting = webView.getSettings();
        webSetting.setJavaScriptEnabled(true);
        webSetting.setDisplayZoomControls(true);
        webView.loadUrl(postUrl);

        toolbar = findViewById(R.id.toolbardd);
        setSupportActionBar(toolbar);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        coordinatorLayout=findViewById(R.id.coordinatorLayout);

        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(PrefManager.KEY_MOBILE);

        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(_from==1) {
                    Intent i = new Intent(Wb1_access.this, SelectePaymentOption.class);
                    startActivity(i);
                    finish();
                    overridePendingTransition(R.anim.fade_in, R.anim.fade_out);

                }else{
                    Intent i = new Intent(Wb1_access.this, Canteen_Mainactivity.class);
                    startActivity(i);
                    finish();
                    overridePendingTransition(R.anim.fade_in, R.anim.fade_out);
                }
            }
        });
        mDatabase = FirebaseDatabase.getInstance().getReference();
        mDatabase.child("Payment").child(_PhoneNo).addValueEventListener(new FirebaseDataListenerP());
    }


    private class FirebaseDataListenerP implements ValueEventListener {
        private String _paid;

        @Override
        public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
            _paid=(String) dataSnapshot.child("Paid").getValue();
            if (_paid != null) {
                if(!first){
                    first=true;
                    if (_paid.contains("1")) {
                        ViewDialogFailedSuccess alert = new ViewDialogFailedSuccess();
                        alert.showDialog(Wb1_access.this, "Success! Thank you", false);
                    }else {
                        ViewDialogFailed alert = new ViewDialogFailed();
                        if (_paid.contains("2")) {
                            alert.showDialog(Wb1_access.this, "Payment cancelled", false);
                        } else {
                            alert.showDialog(Wb1_access.this, "Error. Please try again", true);

                        }
                    }
                }
            }
        }

        @Override
        public void onCancelled(@NonNull DatabaseError databaseError) {

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
                        mDatabase.child("Payment").child(_PhoneNo).removeValue();
                        Intent i = new Intent(Wb1_access.this, SelectePaymentOption.class);
                        startActivity(i);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                        finish();
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
                dialog1.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
                dialog1.getWindow().getAttributes().windowAnimations = R.style.DialogAnimation;
                TextView text = dialog1.findViewById(R.id.text_dialog);
                text.setText(msg);

                Button dialogButton = dialog1.findViewById(R.id.btn_dialog);


                dialogButton.setText("Ok");

                dialogButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        mDatabase.child("Payment").child(_PhoneNo).removeValue();
                        checkEmail(2);
                        dialog1.dismiss();
                    }
                });

                dialog1.show();


            }
        }
    }

    private void checkEmail(final int _pay) {
        StringRequest eventoReq = new StringRequest(Request.Method.POST, com.liteafrica.izigourmet.Config_URL.URL_BOOKING_MODE,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {
                            if (!Wb1_access.this.isFinishing()) {
                                new AlertDialog.Builder(Wb1_access.this, R.style.AlertDialogTheme)
                                        .setTitle("Thank you for ordering with us.")
                                        .setCancelable(false)
                                        .setMessage("Our representative will contact you soon!")
                                        .setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                                            @Override
                                            public void onClick(DialogInterface dialog, int which) {
                                                DatabaseReference mDatabase = FirebaseDatabase.getInstance().getReference();
                                                String[] pars = pref.getUniqueRide().split("\\.");
                                                String con = TextUtils.join("", pars);
                                                mDatabase.child("IziGourmet").child(con).child("Payment").setValue(String.valueOf(_pay));
                                                if (_pay == 2) {
                                                    mDatabase.child("IziGourmet").child(con).child("Verify").setValue(String.valueOf(1));
                                                }
                                                pref.setPayment(_pay);
                                                Intent i = new Intent(Wb1_access.this, Canteen_Mainactivity.class);
                                                startActivity(i);
                                                finish();
                                                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                                dialog.cancel();
                                            }
                                        })
                                        .show();
                            }
                        } else {
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
                params.put("mobile", _PhoneNo);
                params.put("uniqueid", pref.getUniqueRide());
                params.put("pay", String.valueOf(_pay));
                return params;
            }

        };

        // Añade la peticion a la cola
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
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_refresh, menu);
        return true;

    }




    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == R.id.action_refresh) {
            overridePendingTransition(0, 0);
            startActivity(getIntent());
        }
        return super.onOptionsItemSelected(item);
    }


    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if ((keyCode == KeyEvent.KEYCODE_BACK) && this.webView.canGoBack()) {
            this.webView.goBack();
            return true;
        } else {
            if(_from==1) {
                Intent i = new Intent(Wb1_access.this, SelectePaymentOption.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.fade_in, R.anim.fade_out);

            }else{
                Intent i = new Intent(Wb1_access.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.fade_in, R.anim.fade_out);
            }
            return true;
        }

        // return super.onKeyDown(keyCode, event);
    }



    private class CustomWebViewClient extends WebViewClient {
        @Override
        public void onPageStarted(WebView view, String url, Bitmap favicon) {
            // TODO Auto-generated method stub
            super.onPageStarted(view, url, favicon);
        }

        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            // TODO Auto-generated method stub

            view.loadUrl(url);
            return true;

        }

        @Override
        public void onReceivedError(WebView view, int errorCode,
                                    String description, String failingUrl) {
            // TODO Auto-generated method stub
            Toast.makeText(Wb1_access.this, "Oh no! " + description, Toast.LENGTH_SHORT).show();
            //super.onReceivedError(view, errorCode, description, failingUrl);
        }

        @Override
        public void onPageFinished(WebView view, String url) {
            // TODO Auto-generated method stub
            super.onPageFinished(view, url);
            progressBar.setVisibility(View.GONE);
        }
    }

}
