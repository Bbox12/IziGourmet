package com.liteafrica.izigourmet.Activites;

import android.Manifest;
import android.app.Activity;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.graphics.drawable.BitmapDrawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.text.TextUtils;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
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
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.snackbar.Snackbar;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.ConnectionDetector;
import com.liteafrica.izigourmet.Login.ServiceOffer;
import com.liteafrica.izigourmet.Login.SignIn;
import com.liteafrica.izigourmet.LruBitmapCache;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.net.UnknownHostException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.regex.Pattern;

import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;

/**
 * Created by parag on 29/12/17.
 */

public class Update_profile extends AppCompatActivity implements View.OnClickListener {


    public static final int MULTIPLE_PERMISSIONS = 10;
    private static final String TAG = SignIn.class.getSimpleName();
    Boolean isInternetPresent = false;
    ConnectionDetector cd;
    private NetworkImageView ProfileImage;
    private EditText Name, _PhoneNo;
    private Button Logout;
    private Toolbar toolbar;
    private ProgressBar progressBar;
    private String Name_giver = "";
    private boolean permissionsAllowd = false;
    private String _PhoneNo_giver = "";
    private double My_lat = 0, My_long = 0;
    private String userChoosenTask;
    private int REQUEST_CAMERA = 0, SELECT_FILE = 1;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String User_image, User_name;
    private EditText Email, dStreetfirst, dCity, dState, dCountry, dPin;
    private String User_address = "";
    private String User_state = "";
    private String User_country = "";
    private String User_pin = "";
    private String User_city = "";
    private String User_Email = "";
    private String filePath_;
    private CoordinatorLayout coordinatorLayout;
    private TextView orders;
    private ImageView _i4;
    private String User_Phone;
    private ImageView edit;

    private static boolean isValidPhoneNumber(String phone) {
        boolean check = false;
        if (!Pattern.matches("[a-zA-Z]+", phone)) {
            check = phone.length() >= 6 && phone.length() <= 12;
        }
        return check;

    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.profile_update);
        progressBar = findViewById(R.id.progressBarprofile);
        ProfileImage = findViewById(R.id.img_profil_update);
        Name = findViewById(R.id.editText_name);
        _PhoneNo = findViewById(R.id.editText_mobile);
        Logout = findViewById(R.id.logout);
        cd = new ConnectionDetector(getApplicationContext());
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo_giver = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        Email = findViewById(R.id.editText_email);
        dStreetfirst = findViewById(R.id.faddresso);
        dCity = findViewById(R.id.cityo);
        dState = findViewById(R.id.stateo);
        dCountry = findViewById(R.id.countryo);
        dPin = findViewById(R.id.pino);
        ImageView arrow = findViewById(R.id.arrow);
        coordinatorLayout = findViewById(R.id.coordinatorLayout);

        arrow.setOnClickListener(this);

        if (_PhoneNo_giver != null) {
            launchHomeScreen();

        }
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

        edit = findViewById(R.id.edit);
        edit.setOnClickListener(this);

        checkAndRequestPermissions();
    }

    @Override
    protected void onResume() {
        super.onResume();
        isInternetPresent = cd.isConnectingToInternet();
        if (isInternetPresent) {
            ProfileImage.setOnClickListener(this);
            Logout.setOnClickListener(this);
        } else {
            Snackbar.make(getWindow().getDecorView().getRootView(), "No Internet,Connect to internet", Snackbar.LENGTH_INDEFINITE).show();

        }
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {


            case R.id._i4: {
                if (_PhoneNo_giver != null) {
                    if (pref.get_food_money() != 0) {
                        pref.set_cID1(1);
                        Intent o = new Intent(Update_profile.this, GooglemapApp.class);
                        startActivity(o);
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);

                    } else {
                        if (!Update_profile.this.isFinishing()) {
                            new AlertDialog.Builder(Update_profile.this, R.style.AlertDialogTheme)
                                    .setTitle("Your cart is empty")
                                    .setMessage("Please add items to your cart.")
                                    .setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialog, int which) {
                                            dialog.cancel();
                                            Intent o = new Intent(Update_profile.this, Canteen_Mainactivity.class);
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
                    if (!Update_profile.this.isFinishing()) {
                        new AlertDialog.Builder(Update_profile.this, R.style.AlertDialogTheme)
                                .setTitle("Please login.")
                                .setMessage("You need to login to complete your order.")
                                .setPositiveButton("Login", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(Update_profile.this, ServiceOffer.class);
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
                Intent i = new Intent(Update_profile.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                break;


            case R.id.logout:
                Name_giver = Name.getText().toString();
                User_Email = Email.getText().toString();
                String emailPattern = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";

                if (!TextUtils.isEmpty(User_Email) && !User_Email.matches(emailPattern)) {
                    User_Email = "";
                    Email.setText("");
                    Toast.makeText(getApplicationContext(), "Invalid email address", Toast.LENGTH_SHORT).show();

                }

                User_address = dStreetfirst.getText().toString();
                User_city = dCity.getText().toString();
                User_country = dCountry.getText().toString();
                User_pin = dPin.getText().toString();
                User_state = dState.getText().toString();
                if (isValidPhoneNumber(_PhoneNo.getText().toString().trim())) {
                    new PostDataTOServer().execute();
                } else {
                    _PhoneNo.setError("Not a valid no");
                }
                break;
            case R.id.edit:
                if (permissionsAllowd) {
                    selectImage();
                } else {
                    checkAndRequestPermissions();
                }
                break;

        }
    }

    private void selectImage() {
        final CharSequence[] items = {"Take Photo", "Choose from Library",
                "Cancel"};
        AlertDialog.Builder builder = new AlertDialog.Builder(Update_profile.this, R.style.AlertDialogTheme);
        builder.setTitle("Add Photo!");
        builder.setItems(items, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int item) {
                if (items[item].equals("Take Photo")) {
                    cameraIntent();
                } else if (items[item].equals("Choose from Library")) {
                    galleryIntent();
                } else if (items[item].equals("Cancel")) {
                    dialog.dismiss();
                }
            }
        });
        builder.show();
    }

    private void cameraIntent() {
        Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        startActivityForResult(intent, REQUEST_CAMERA);
    }

    private void galleryIntent() {
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_GET_CONTENT);//
        startActivityForResult(Intent.createChooser(intent, "Select File"), SELECT_FILE);
    }


    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode == Activity.RESULT_OK) {
            if (requestCode == SELECT_FILE)
                onSelectFromGalleryResult(data);
            else if (requestCode == REQUEST_CAMERA)
                onCaptureImageResult(data);
        }

    }

    private void onSelectFromGalleryResult(Intent data) {
        Bitmap bm = null;
        if (data != null) {
            try {
                bm = MediaStore.Images.Media.getBitmap(getApplicationContext().getContentResolver(), data.getData());
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        ProfileImage.setImageBitmap(bm);
    }

    private void onCaptureImageResult(Intent data) {
        Bitmap thumbnail = (Bitmap) data.getExtras().get("data");
        ByteArrayOutputStream bytes = new ByteArrayOutputStream();
        thumbnail.compress(Bitmap.CompressFormat.JPEG, 90, bytes);
        File destination = new File(Environment.getExternalStorageDirectory(),
                System.currentTimeMillis() + ".jpg");
        FileOutputStream fo;
        try {
            destination.createNewFile();
            fo = new FileOutputStream(destination);
            fo.write(bytes.toByteArray());
            fo.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
        ProfileImage.setImageBitmap(thumbnail);
    }

    private void checkAndRequestPermissions() {
        int camerapermission = ContextCompat.checkSelfPermission(this, Manifest.permission.CAMERA);
        int writepermission = ContextCompat.checkSelfPermission(this, Manifest.permission.WRITE_EXTERNAL_STORAGE);


        List<String> listPermissionsNeeded = new ArrayList<>();

        if (camerapermission != PackageManager.PERMISSION_GRANTED) {
            listPermissionsNeeded.add(Manifest.permission.CAMERA);
        }
        if (writepermission != PackageManager.PERMISSION_GRANTED) {
            listPermissionsNeeded.add(Manifest.permission.WRITE_EXTERNAL_STORAGE);
        }

        if (!listPermissionsNeeded.isEmpty()) {
            ActivityCompat.requestPermissions(this, listPermissionsNeeded.toArray(new String[listPermissionsNeeded.size()]), MULTIPLE_PERMISSIONS);

        } else {
            permissionsAllowd = true;
        }

    }

    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String[] permissions, int[] grantResults) {
        Log.d(TAG, "Permission callback called-------");
        switch (requestCode) {
            case MULTIPLE_PERMISSIONS: {

                Map<String, Integer> perms = new HashMap<>();
                // Initialize the map with both permissions
                perms.put(Manifest.permission.CAMERA, PackageManager.PERMISSION_GRANTED);
                perms.put(Manifest.permission.WRITE_EXTERNAL_STORAGE, PackageManager.PERMISSION_GRANTED);


                // Fill with actual results from user
                if (grantResults.length > 0) {
                    for (int i = 0; i < permissions.length; i++)
                        perms.put(permissions[i], grantResults[i]);
                    // Check for both permissions
                    if (perms.get(Manifest.permission.CAMERA) == PackageManager.PERMISSION_GRANTED
                            && perms.get(Manifest.permission.WRITE_EXTERNAL_STORAGE) == PackageManager.PERMISSION_GRANTED
                    ) {
                        Log.d(TAG, "sms & location services permission granted");
                        // process the normal flow
                        selectImage();

                    } else {
                        Log.d(TAG, "Some permissions are not granted ask again ");

                        checkAndRequestPermissions();
                    }
                }
            }
            break;

        }


    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_save, menu);
        return true;

    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {

            case R.id.action_save:
                pref.clearSession();
                Intent i = new Intent(Update_profile.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        Intent i = new Intent(Update_profile.this, Canteen_Mainactivity.class);
        startActivity(i);
        finish();
        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
    }


    private void launchHomeScreen() {
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_DETAILS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        JSONObject jsonObj = null;
                        try {
                            jsonObj = new JSONObject(response);
                            JSONArray login = jsonObj.getJSONArray("login");
                            for (int i = 0; i < login.length(); i++) {
                                JSONObject c = login.getJSONObject(i);
                                if (!c.isNull("Phone_No")) {
                                    User_image = c.getString("Photo");
                                    User_name = c.getString("Name");
                                    User_address = c.getString("Address");
                                    User_state = c.getString("State");
                                    User_country = c.getString("Country");
                                    User_pin = c.getString("Pin");
                                    User_city = c.getString("City");
                                    User_Email = c.getString("Email");
                                    User_Phone = c.getString("Phone_No");
                                }
                            }


                        } catch (JSONException ex) {
                            ex.printStackTrace();
                        }


                        progressBar.setVisibility(View.GONE);
                        if (User_name != null) {
                            Name.setText(User_name);
                        }
                        if (User_name != null) {
                            _PhoneNo.setText(User_Phone);
                        }


                        if (User_Email != null && !User_Email.contains("null")) {
                            Email.setText(User_Email);
                        }
                        if (User_pin != null && !User_pin.contains("null")) {
                            dPin.setText(User_pin);
                        }

                        if (User_address != null && !User_address.contains("null")) {
                            dStreetfirst.setText(User_address);
                        }
                        if (User_state != null && !User_state.contains("null")) {
                            dState.setText(User_state);
                        }
                        if (User_city != null && !User_city.contains("null")) {
                            dCity.setText(User_city);
                        }
                        if (User_country != null && !User_country.contains("null")) {
                            dCountry.setText(User_country);
                        }

                        if (User_image != null && !TextUtils.isEmpty(User_image)) {

                            String url = User_image.replaceAll(" ", "%20");
                            ImageLoader imageLoader = LruBitmapCache.getInstance(Update_profile.this)
                                    .getImageLoader();
                            imageLoader.get(url, ImageLoader.getImageListener(ProfileImage,
                                    R.drawable.com_facebook_profile_picture_blank_portrait, R.drawable
                                            .com_facebook_profile_picture_blank_portrait));
                            ProfileImage.setImageUrl(url, imageLoader);
                        }

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
                params.put("_mId", _PhoneNo_giver);
                return params;
            }

        };
        eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                3000,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        AppController.getInstance().addToRequestQueue(eventoReq);


    }


    private class PostDataTOServer extends AsyncTask<Void, Integer, String> {


        private boolean success;
        private File destination;

        @Override
        protected void onPreExecute() {

            super.onPreExecute();
            if (ProfileImage.getDrawable() != null) {
                Bitmap bitmap1 = ((BitmapDrawable) ProfileImage.getDrawable()).getBitmap();
                final File mediaStorageDir = new File(
                        Environment.getExternalStorageDirectory().getAbsolutePath() + "^");
                String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss",
                        Locale.getDefault()).format(new Date());
                ByteArrayOutputStream bytes = new ByteArrayOutputStream();
                bitmap1.compress(Bitmap.CompressFormat.PNG, 100, bytes);
                destination = new File(mediaStorageDir.getPath() + File.separator + "IMG_" + timeStamp + ".jpg");
                FileOutputStream fo;
                try {
                    destination.createNewFile();
                    fo = new FileOutputStream(destination);
                    fo.write(bytes.toByteArray());
                    fo.close();
                    filePath_ = destination.getPath();

                } catch (FileNotFoundException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            progressBar.setVisibility(View.VISIBLE);
        }

        protected String doInBackground(Void... args) {
            return uploadFile();
        }

        private String uploadFile() {
            // TODO Auto-generated method stub
            String res = null;
            final MediaType MEDIA_TYPE_PNG = MediaType.parse("image/*");
            //String filename = filePath_.substring(filePath_.lastIndexOf("^") + 1);

            try {
                File sourceFile = new File(filePath_);
                RequestBody requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("name", Name_giver)
                        .addFormDataPart("mobile", _PhoneNo_giver)
                        .addFormDataPart("email", User_Email)
                        .addFormDataPart("address", User_address)
                        .addFormDataPart("city", User_city)
                        .addFormDataPart("state", User_state)
                        .addFormDataPart("country", User_country)
                        .addFormDataPart("pin", User_pin)
                        .addFormDataPart("my_lat", String.valueOf(My_lat))
                        .addFormDataPart("my_long", String.valueOf(My_long))
                        .addFormDataPart("image", sourceFile.getName(), RequestBody.create(MEDIA_TYPE_PNG, sourceFile))

                        .build();

                Request request = new Request.Builder()
                        .url(com.liteafrica.izigourmet.Config_URL.URL_STORE_USER_PROFILE)
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
                success = false;
            } catch (Exception e) {
                Log.e("TAG", "Other Error: " + e.getLocalizedMessage());
                success = false;
            }


            return res;

        }

        protected void onPostExecute(String file_url) {
            progressBar.setVisibility(View.GONE);
            if (success) {
                if (destination != null) {
                    File file = new File(destination.getPath());
                    file.delete();
                    if (file.exists()) {
                        try {
                            file.getCanonicalFile().delete();
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                        if (file.exists()) {
                            getApplicationContext().deleteFile(file.getName());
                        }
                    }
                }
                ViewDialogFailedSuccess alert = new ViewDialogFailedSuccess();
                alert.showDialog(Update_profile.this, "Succesfully stored information.", false);
            } else {
                ViewDialogFailed alert = new ViewDialogFailed();
                alert.showDialog(Update_profile.this, "Failed to store information! Please try another time.", true);
            }

        }


    }

    public class ViewDialogFailed {

        public void showDialog(Activity activity, String msg, Boolean noDate) {
            if (!activity.isFinishing()) {
                final Dialog dialog1 = new Dialog(activity);
                dialog1.requestWindowFeature(Window.FEATURE_NO_TITLE);
                dialog1.setCancelable(true);

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
                dialog1.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
                dialog1.getWindow().getAttributes().windowAnimations = R.style.DialogAnimation;
                TextView text = dialog1.findViewById(R.id.text_dialog);
                text.setText(msg);


                Button dialogButton = dialog1.findViewById(R.id.btn_dialog);


                dialogButton.setText("Ok");

                dialogButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        pref.createLogin(_PhoneNo_giver, Name_giver);
                        Intent i = new Intent(Update_profile.this, Splash_screen.class);
                        startActivity(i);
                        finish();
                        overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                        dialog1.dismiss();
                    }
                });

                dialog1.show();


            }
        }
    }
}
