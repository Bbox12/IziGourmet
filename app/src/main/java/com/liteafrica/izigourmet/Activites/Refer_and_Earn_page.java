package com.liteafrica.izigourmet.Activites;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import com.google.android.gms.appinvite.AppInviteInvitation;
import com.google.android.material.snackbar.Snackbar;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.HttpHandler;
import com.liteafrica.izigourmet.Login.ServiceOffer;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.HashMap;

/**
 * Created by parag on 28/02/18.
 */

public class Refer_and_Earn_page extends AppCompatActivity implements View.OnClickListener {

    private static final String TAG = Refer_and_Earn_page.class.getSimpleName();
    private static final int REQUEST_INVITED = 101;
    private Toolbar toolbar;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _PhoneNo;
    private double My_lat = 0, My_long = 0;
    private String Refer_code;
    private EditText Refer_text;
    private ImageView WhatsApp, Messenger, Email, Message, Twitter, Facebook;
    private Button Refer;
    private String strShareMessage;
    private ImageView Gplus;
    private TextView orders;
    private ImageView _i4;
    private TextView _address;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.refer_earn);

        Refer_text = findViewById(R.id.referalCode);

        WhatsApp = findViewById(R.id.whatsapp);
        Messenger = findViewById(R.id.messenger);
        Email = findViewById(R.id.email);
        Message = findViewById(R.id.message);
        Twitter = findViewById(R.id.twitter);
        Facebook = findViewById(R.id.facebok);
        Refer = findViewById(R.id.buttonRefer);
        Gplus = findViewById(R.id.gplus);

        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);


        WhatsApp.setOnClickListener(this);
        Message.setOnClickListener(this);
        Messenger.setOnClickListener(this);
        Email.setOnClickListener(this);
        Twitter.setOnClickListener(this);
        Facebook.setOnClickListener(this);
        Refer.setOnClickListener(this);
        Gplus.setOnClickListener(this);
        ImageView arrow = findViewById(R.id.arrow);
        arrow.setOnClickListener(this);
        orders = findViewById(R.id.orders);
        orders.setOnClickListener(this);
        if (pref.get_food_items() != 0) {
            orders.setText(String.valueOf(pref.get_food_items()));

        }

        _address = findViewById(R.id.address);
        if (pref.getDropAt() != null) {
            _address.setText(pref.getDropAt());
        }
        _i4 = findViewById(R.id._i4);
        _i4.setOnClickListener(this);
    }

    @Override
    protected void onResume() {
        super.onResume();
        new GetPromo_Reference_Code().execute();
    }

    @Override
    public void onClick(View v) {

        switch (v.getId()) {

            case R.id._i4: {
                if (_PhoneNo != null) {
                    if (pref.get_food_money() != 0) {
                        pref.set_cID1(1);
                        Intent o = new Intent(Refer_and_Earn_page.this, GooglemapApp.class);

                        startActivity(o);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

                    } else {
                        if (!Refer_and_Earn_page.this.isFinishing()) {
                            new AlertDialog.Builder(Refer_and_Earn_page.this, R.style.AlertDialogTheme)
                                    .setTitle("Your cart is empty")
                                    .setMessage("Please add items to your cart.")
                                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                            Intent o = new Intent(Refer_and_Earn_page.this, Canteen_Mainactivity.class);
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
                    if (!Refer_and_Earn_page.this.isFinishing()) {
                        new AlertDialog.Builder(Refer_and_Earn_page.this, R.style.AlertDialogTheme)
                                .setTitle("Please login.")
                                .setMessage("You need to login to complete your order.")
                                .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(Refer_and_Earn_page.this, ServiceOffer.class);

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
                Intent i = new Intent(Refer_and_Earn_page.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                break;

            case R.id.whatsapp:
                sendAppMsg(v);
                break;
            case R.id.messenger:
                Intent sendIntent = new Intent();
                sendIntent.setAction(Intent.ACTION_SEND);

                sendIntent
                        .putExtra(Intent.EXTRA_TEXT,
                                strShareMessage);
                sendIntent.setType("text/plain");
                sendIntent.setPackage("com.facebook.orca");
                try {
                    startActivity(sendIntent);
                } catch (android.content.ActivityNotFoundException ex) {
                    Toast.makeText(getApplicationContext(), "Please Install Facebook Messenger", Toast.LENGTH_LONG).show();
                }
                break;
            case R.id.message:
                Intent smsIntent = new Intent(Intent.ACTION_VIEW);
                smsIntent.setType("vnd.android-dir/mms-sms");
                smsIntent.putExtra("address", "");

                smsIntent.putExtra("sms_body", strShareMessage);
                startActivity(smsIntent);
                break;
            case R.id.email:
                sendEmail(strShareMessage);
                break;
            case R.id.twitter:
                try {
                    getApplicationContext().getPackageManager().getPackageInfo("com.twitter.android", 0);
                    Intent intent = new Intent(Intent.ACTION_SEND);
                    intent.setClassName("com.twitter.android", "com.twitter.android.composer.ComposerActivity");
                    intent.setType("text/plain");
                    intent.putExtra(Intent.EXTRA_TEXT, "Your text");
                    startActivity(intent);

                } catch (Exception e) {
                    Toast.makeText(getApplicationContext(), "Twitter is not installed on this device", Toast.LENGTH_LONG).show();

                }
                break;
            case R.id.facebok:
                sendAppFacebook(v);
                break;

            case R.id.buttonRefer:
                onInviteClicked();
                break;
            case R.id.gplus:
                onInviteClicked();
                break;
            default:
                break;

        }
    }

    public void sendAppFacebook(View view) {

        Intent intent = new Intent(Intent.ACTION_SEND);
        intent.setType("text/plain");
        String text = strShareMessage;
        // change with required  application package

        intent.setPackage("com.facebook.katana");
        if (intent != null) {
            intent.putExtra(Intent.EXTRA_TEXT, text);//
            startActivity(Intent.createChooser(intent, text));
        } else {

            Toast.makeText(this, "App not found", Toast.LENGTH_SHORT)
                    .show();
        }
    }

    public void sendAppMsg(View view) {

        Intent intent = new Intent(Intent.ACTION_SEND);
        intent.setType("text/plain");
        String text = strShareMessage;
        // change with required  application package

        intent.setPackage("com.whatsapp");
        if (intent != null) {
            intent.putExtra(Intent.EXTRA_TEXT, text);//
            startActivity(Intent.createChooser(intent, text));
        } else {

            Toast.makeText(this, "App not found", Toast.LENGTH_SHORT)
                    .show();
        }
    }

    private void onInviteClicked() {
        Intent intent = new AppInviteInvitation.IntentBuilder("Send mail or SMS")
                .setMessage("Download MeatExpress")
                .setDeepLink(Uri.parse("IziGourmet://use/" + "=" + _PhoneNo + ":" + Refer_code))
                .setCustomImage(Uri.parse("http://139.59.38.160/IziGourmet/logo.png"))
                .setCallToActionText("Join")
                .build();
        startActivityForResult(intent, REQUEST_INVITED);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        switch (requestCode) {
            //checking for our ColorSelectorActivity using request code

            case REQUEST_INVITED:
                if (resultCode == RESULT_OK) {

                    String[] ids = AppInviteInvitation.getInvitationIds(resultCode, data);


                    if (ids.length < 1) {
                        Toast.makeText(getApplicationContext(), "Please invite friends to join your community", Toast.LENGTH_SHORT).show();
                    } else {
                        Toast.makeText(getApplicationContext(), "Thank you!", Toast.LENGTH_SHORT).show();

                        finish();


                    }

                    break;
                }

            default:
                break;
        }

    }

    private String urlEncode(String s) {
        try {
            return URLEncoder.encode(s, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            Log.wtf(TAG, "UTF-8 should always be supported", e);
            return "";
        }
    }

    public void sendEmail(String s) {

        Intent i = new Intent(Intent.ACTION_SENDTO);
        i.setType("text/plain");
        i.setData(Uri.parse("mailto:"));
        i.putExtra(Intent.EXTRA_EMAIL, new String[]{"MeatExpress@gmail.com"});
        i.putExtra(Intent.EXTRA_SUBJECT, "Download MeatExpress");
        i.putExtra(Intent.EXTRA_TEXT, s);
        try {
            startActivity(Intent.createChooser(i, "Email us.."));
        } catch (android.content.ActivityNotFoundException ex) {

            Snackbar snackbar = Snackbar
                    .make(getWindow().getDecorView().getRootView(), "There are no email clients installed.", Snackbar.LENGTH_LONG);
            View sbView = snackbar.getView();
            TextView textView = sbView.findViewById(R.id.snackbar_text);
            textView.setTextColor(Color.WHITE);
            snackbar.show();
        }

    }


    @Override
    public void onBackPressed() {
        super.onBackPressed();
        Intent i = new Intent(Refer_and_Earn_page.this, Canteen_Mainactivity.class);
        startActivity(i);
        finish();
        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
    }

    private class GetPromo_Reference_Code extends AsyncTask<Void, Void, Void> {

        private int User_refernce_code_coupon_Amt;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        @Override
        protected Void doInBackground(Void... arg0) {
            HttpHandler sh = new HttpHandler();
            // Making a request to url and getting response
            String jsonStr = sh.makeServiceCall(com.liteafrica.izigourmet.Config_URL.GET_SETTINGS);

            Log.e(TAG, "Response from url: " + jsonStr);

            if (jsonStr != null) {
                try {
                    JSONObject jsonObj = new JSONObject(jsonStr);

                    // Getting JSON Array node
                    JSONArray User = jsonObj.getJSONArray("User");
                    JSONArray Settings_default = jsonObj.getJSONArray("Settings");

                    for (int i = 0; i < Settings_default.length(); i++) {
                        JSONObject c = Settings_default.getJSONObject(i);
                        User_refernce_code_coupon_Amt = c.getInt("User_refernce_code_coupon_Amt");
                    }


                    for (int i = 0; i < User.length(); i++) {
                        JSONObject c = User.getJSONObject(i);
                        String relation = c.getString("Phone_No");
                        if (!relation.contains("null")) {

                            if (relation.matches(_PhoneNo)) {
                                Refer_code = c.getString("Reference_Code");

                            }

                        }
                    }


                } catch (final JSONException ignored) {


                }
            } else {
                Log.e(TAG, "Couldn't get json from server.");

            }

            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            super.onPostExecute(result);
            if (Refer_code != null) {
                Refer_text.setText(Refer_code);
                strShareMessage = "\nI have MeatExpress coupon worth R" + User_refernce_code_coupon_Amt + " for you. Sign up with my code " + Refer_code +
                        " to avail the coupon and ride!" + "https://play.google.com/store/apps/details?id=" + getPackageName();


            }
        }
    }
}
