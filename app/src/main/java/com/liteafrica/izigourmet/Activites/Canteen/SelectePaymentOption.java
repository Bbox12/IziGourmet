package com.liteafrica.izigourmet.Activites.Canteen;

import android.Manifest;
import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.graphics.Color;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.Window;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.NetworkError;
import com.android.volley.NetworkResponse;
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.HttpHeaderParser;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.snackbar.Snackbar;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.liteafrica.izigourmet.Activites.Main_Page.Wb1_access;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.PrefManager;
import com.liteafrica.izigourmet.R;
import com.liteafrica.izigourmet.VolleyMultipartRequest;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class SelectePaymentOption extends AppCompatActivity implements View.OnClickListener {

    private static final int MULTIPLE_PERMISSIONS = 102;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _phoneNo;
    private ProgressBar progressBar;
    private CoordinatorLayout coordinatorLayout;
    private Toolbar toolbar;
    private TextView _credit, _price, payuLink, googleLink;
    private TextView _bankEFT, upload,_cardpayment;
    private int REQUEST_CAMERA = 0, SELECT_FILE = 1;
    private String selectedVideoPath;
    private RequestQueue rQueue;
    private ProgressDialog mProgressDialog;
    private TextView y5;
    private String _Name;

    public static String getPath(Context context, Uri uri) {
        String result = null;
        String[] proj = {MediaStore.Images.Media.DATA};
        Cursor cursor = context.getContentResolver().query(uri, proj, null, null, null);
        if (cursor != null) {
            if (cursor.moveToFirst()) {
                int column_index = cursor.getColumnIndexOrThrow(proj[0]);
                result = cursor.getString(column_index);
            }
            cursor.close();
        }
        if (result == null) {
            result = "Not found";
        }
        return result;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.paymentoptionselect);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        _Name = user.get(PrefManager.KEY_NAME);
        progressBar = findViewById(R.id.progressBarSplash);
        coordinatorLayout = findViewById(R.id.cor_home_main);
        toolbar = findViewById(R.id.toolbardd);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        _credit = findViewById(R.id.credit);
        _credit.setOnClickListener(this);

        _bankEFT = findViewById(R.id._bankEFT);
        _bankEFT.setOnClickListener(this);

        _cardpayment = findViewById(R.id._cardpayment);
        _cardpayment.setOnClickListener(this);

        y5 = findViewById(R.id.y5);
        y5.setOnClickListener(this);

        _price = findViewById(R.id._price);
        if(pref.getTotal().contains(",")) {
            String money = pref.getTotal().replace(',', '.');
            _price.setText("R" + money);
        }else{
            _price.setText("R" + pref.getTotal());
        }


        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Intent i = new Intent(SelectePaymentOption.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.fade_in, R.anim.fade_out);

            }
        });


    }

    @Override
    protected void onResume() {
        super.onResume();
        _bankEFT.setEnabled(true);
    }

    private void checkEmail(final int _pay) {
        StringRequest eventoReq = new StringRequest(Request.Method.POST, com.liteafrica.izigourmet.Config_URL.URL_BOOKING_MODE,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.w("kk", response);


                        String[] par = response.split("error");
                        if (par[1].contains("false")) {
                            if (!SelectePaymentOption.this.isFinishing()) {
                                new AlertDialog.Builder(SelectePaymentOption.this, R.style.AlertDialogTheme)
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
                                                Intent i = new Intent(SelectePaymentOption.this, Canteen_Mainactivity.class);
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
                                            _bankEFT.setEnabled(true);
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
                params.put("mobile", _phoneNo);
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
                            _bankEFT.setEnabled(true);
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
                            _bankEFT.setEnabled(true);
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
                            _bankEFT.setEnabled(true);
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
                            _bankEFT.setEnabled(true);
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
                            _bankEFT.setEnabled(true);
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
        if (view.getId() == R.id.credit) {
            pref.setPayment(1);
            checkEmail(1);
        }
        if (view.getId() == R.id._bankEFT) {
            _bankEFT.setEnabled(false);
          //  checkEmail(2);
            Intent o1 = new Intent(SelectePaymentOption.this, Wb1_access.class);
            String money;
            if(pref.getTotal().contains(",")) {
                 money = pref.getTotal().replace(',', '.');
            }else{
                money = pref.getTotal();
            }
            String url= "http://139.59.38.160/IziGourmet/Dashboard/Payment.php?amount="+money+"&orderid="+pref.getOrder()+"&name="+_Name
                    +"&ID="+_phoneNo;
            Log.e("url", url);
            o1.putExtra("url", url);
            startActivity(o1);
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            finish();
        }
        if (view.getId() == R.id._cardpayment) {
            String money;
            if(pref.getTotal().contains(",")) {
                money = pref.getTotal().replace(',', '.');
            }else{
                money = pref.getTotal();
            }
            Intent o1 = new Intent(SelectePaymentOption.this, Wb1_access.class);
            String url= "http://139.59.38.160/IziGourmet/Dashboard/PaymentCard.php?amount="+money+"&orderid="+pref.getOrder()+"&name="+_Name
                    +"&ID="+_phoneNo;
            Log.e("url", url);
            o1.putExtra("url", url);
            startActivity(o1);
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            finish();
        }
        if (view.getId() == R.id.y5) {
            if (!SelectePaymentOption.this.isFinishing()) {
                final Dialog dialog = new Dialog(SelectePaymentOption.this, R.style.AlertDialogTheme);

                dialog.setCancelable(true);
                dialog.setCanceledOnTouchOutside(true);
                dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
                dialog.setContentView(R.layout.dialogeft);

                dialog.show();

            }
        }
    }

    private void galleryIntent() {
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_PICK);
        startActivityForResult(Intent.createChooser(intent, "Select file"), SELECT_FILE);
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode == Activity.RESULT_OK) {
            if (requestCode == SELECT_FILE) {
                Uri selectedImageUri = data.getData();
                selectedVideoPath = getPath(SelectePaymentOption.this, selectedImageUri);
                mProgressDialog = new ProgressDialog(SelectePaymentOption.this, R.style.Theme_AppCompat_Light_Dialog_MinWidth);
                mProgressDialog.setIcon(R.mipmap.ic_launcher);
                mProgressDialog.setTitle("Uploading");
                mProgressDialog.setMessage("please wait...");
                mProgressDialog.setIndeterminate(false);
                mProgressDialog.setCancelable(false);
                mProgressDialog.show();
                uploadPDF(selectedVideoPath, selectedImageUri);

            }
        }

    }

    private void checkAndRequestPermissions() {
        int writepermission = ContextCompat.checkSelfPermission(this, Manifest.permission.WRITE_EXTERNAL_STORAGE);
        List<String> listPermissionsNeeded = new ArrayList<>();


        if (writepermission != PackageManager.PERMISSION_GRANTED) {
            listPermissionsNeeded.add(Manifest.permission.WRITE_EXTERNAL_STORAGE);
        }

        if (!listPermissionsNeeded.isEmpty()) {
            ActivityCompat.requestPermissions(this, listPermissionsNeeded.toArray(new String[listPermissionsNeeded.size()]), MULTIPLE_PERMISSIONS);

        } else {
            galleryIntent();
        }

    }

    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String[] permissions, int[] grantResults) {
        Log.d("TAG", "Permission callback called-------");
        if (requestCode == MULTIPLE_PERMISSIONS) {
            Map<String, Integer> perms = new HashMap<>();
            perms.put(Manifest.permission.WRITE_EXTERNAL_STORAGE, PackageManager.PERMISSION_GRANTED);
            if (grantResults.length > 0) {
                for (int i = 0; i < permissions.length; i++)
                    perms.put(permissions[i], grantResults[i]);
                // Check for both permissions
                if (perms.get(Manifest.permission.WRITE_EXTERNAL_STORAGE) == PackageManager.PERMISSION_GRANTED
                ) {
                    galleryIntent();

                } else {
                    Log.d("TAG", "Some permissions are not granted ask again ");
                    checkAndRequestPermissions();
                }
            }
        }


    }


    private void uploadPDF(final String pdfname, Uri pdffile) {

        InputStream iStream = null;
        try {

            iStream = getContentResolver().openInputStream(pdffile);
            final byte[] inputData = getBytes(iStream);

            VolleyMultipartRequest volleyMultipartRequest = new VolleyMultipartRequest(Request.Method.POST, com.liteafrica.izigourmet.Config_URL.FILE_UPLOAD_URL,
                    new Response.Listener<NetworkResponse>() {
                        @Override
                        public void onResponse(NetworkResponse response) {
                            Log.d("ressssssoo", new String(response.data));
                            rQueue.getCache().clear();
                            String json = null;
                            try {
                                if (mProgressDialog != null) {
                                    mProgressDialog.dismiss();
                                }
                                json = new String(
                                        response.data,
                                        HttpHeaderParser.parseCharset(response.headers));
                                String[] par = json.split("error");
                                if (par[1].contains("false")) {
                                    if (!SelectePaymentOption.this.isFinishing()) {
                                        new AlertDialog.Builder(SelectePaymentOption.this, R.style.AlertDialogTheme)
                                                .setTitle("Thank you for ordering with us.")
                                                .setCancelable(false)
                                                .setMessage("Our representative will contact you soon!")
                                                .setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                                                    @Override
                                                    public void onClick(DialogInterface dialog, int which) {
                                                        DatabaseReference mDatabase = FirebaseDatabase.getInstance().getReference();
                                                        String[] pars = pref.getUniqueRide().split("\\.");
                                                        String con = TextUtils.join("", pars);
                                                        mDatabase.child("IziGourmet").child(con).child("Payment").setValue(String.valueOf(1));
                                                        pref.setPayment(2);
                                                        Intent i = new Intent(SelectePaymentOption.this, Canteen_Mainactivity.class);
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
                                                    _bankEFT.setEnabled(true);
                                                    finish();
                                                    overridePendingTransition(0, 0);
                                                    startActivity(getIntent());
                                                }
                                            });
                                    snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
                                    snackbar.show();
                                }
                            } catch (UnsupportedEncodingException e) {
                                e.printStackTrace();
                            }

                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_SHORT).show();
                        }
                    }) {


                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> params = new HashMap<>();
                    params.put("user", _phoneNo);
                    params.put("id", String.valueOf(pref.getUniqueRide()));
                    return params;
                }

                /*
                 *pass files using below method
                 * */
                @Override
                protected Map<String, DataPart> getByteData() {
                    Map<String, DataPart> params = new HashMap<>();
                    params.put("image", new DataPart(pdfname, inputData));
                    return params;
                }
            };
            volleyMultipartRequest.setRetryPolicy(new DefaultRetryPolicy(
                    3000,
                    DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                    DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
            rQueue = Volley.newRequestQueue(SelectePaymentOption.this);
            rQueue.add(volleyMultipartRequest);

        } catch (IOException e) {
            e.printStackTrace();
        }


    }


    @Override
    protected void onStop() {
        super.onStop();
        if (mProgressDialog != null) {
            mProgressDialog.dismiss();
        }
    }

    @Override
    protected void onPause() {
        super.onPause();
        if (mProgressDialog != null) {
            mProgressDialog.dismiss();
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (mProgressDialog != null) {
            mProgressDialog.dismiss();
        }
    }

    public byte[] getBytes(InputStream inputStream) throws IOException {
        ByteArrayOutputStream byteBuffer = new ByteArrayOutputStream();
        int bufferSize = 1024;
        byte[] buffer = new byte[bufferSize];

        int len = 0;
        while ((len = inputStream.read(buffer)) != -1) {
            byteBuffer.write(buffer, 0, len);
        }
        return byteBuffer.toByteArray();
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        //replaces the default 'Back' button action
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent i = new Intent(SelectePaymentOption.this, Canteen_Mainactivity.class);
            startActivity(i);
            finish();
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);


        }
        return true;
    }
}
