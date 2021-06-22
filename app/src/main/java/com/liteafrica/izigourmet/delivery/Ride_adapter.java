package com.liteafrica.izigourmet.delivery;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.textfield.TextInputLayout;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.liteafrica.izigourmet.Adapters.BookingAdapter;
import com.liteafrica.izigourmet.Alarm.AlarmSoundService;
import com.liteafrica.izigourmet.Model.Foods;
import com.liteafrica.izigourmet.R;

import java.io.UnsupportedEncodingException;
import java.net.UnknownHostException;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;
import java.util.Set;

import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;


/**
 * Created by parag on 22/09/16.
 */
public class Ride_adapter extends RecyclerView.Adapter<Ride_adapter.ViewHolder> {

    DecimalFormat dft = new DecimalFormat("0.000000");
    List<String> lst = new ArrayList<String>();
    // The items to display in your RecyclerView
    private ArrayList<Drivers> mItems;
    private LayoutInflater layoutInflater;
    private Context mContext;
    private String _PhoneNo;
    private double My_lat = 0, My_long = 0;
    private DatabaseReference mDatabase;
    private String Driver_image;
    private String con, u_PhoneNo, Vehicle;
    private double from_lat = 0, from_long = 0, to_lat = 0, to_long = 0;
    private String OTP;
    private int Rate_ = 0;
    private com.liteafrica.izigourmet.PrefManager pref;
    private int _seat;
    private String UNIQUE_ID;
    private String _rate;

    public Ride_adapter(Context aContext, ArrayList<Drivers> mItems) {
        this.mItems = mItems;
        this.mContext = aContext;

    }


    @Override
    public long getItemId(int position) {
        return super.getItemId(position);
    }

    @Override
    public int getItemViewType(int position) {
        return super.getItemViewType(position);
    }

    public void setMobile(String mobilet) {
        _PhoneNo = mobilet;
    }

    public void setMyLat(double my_lat, double my_long) {
        My_lat = my_lat;
        My_long = my_long;
    }

    public void setPef(com.liteafrica.izigourmet.PrefManager pref1) {
        pref = pref1;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        //More to come
        View v = LayoutInflater.from(viewGroup.getContext())
                .inflate(R.layout.requestrv, viewGroup, false);
        ViewHolder viewHolder = new ViewHolder(v);
        mDatabase = FirebaseDatabase.getInstance().getReference();
        return viewHolder;
    }

    @Override
    public void onBindViewHolder(final ViewHolder viewHolder, final int position) {
        final Drivers album_pos = mItems.get(position);


        viewHolder.inputFrom.setVisibility(View.GONE);
        viewHolder.inputTo.setVisibility(View.GONE);
        viewHolder.laterDate.setText("Order no " + (album_pos.getUnique_ride(position)));
        if (pref.get_packagesharedPreferences() != null) {
            ArrayList<Foods> mItems1 = new ArrayList<Foods>();
            Set<String> set = pref.get_packagesharedPreferences();
            int Rate = 0;
            for (String s : set) {
                String[] pars = s.split("\\^");
                Foods items = new Foods();
                items.setID(Integer.parseInt(pars[0]));
                items.setNoofItems((int) Double.parseDouble(pars[1]));
                items.seteTEZ_Price((int) Double.parseDouble(pars[2]));
                Rate = (int) (Double.parseDouble(pars[2]) + Rate);
                items.setMenu_Name((pars[3]));
                mItems1.add(items);
            }
            viewHolder._moreRv.setVisibility(View.VISIBLE);
            BookingAdapter sAdapter1 = new BookingAdapter(mContext, mItems1);
            sAdapter1.notifyDataSetChanged();
            LinearLayoutManager mLayoutManager = new LinearLayoutManager(mContext, LinearLayoutManager.VERTICAL, false);
            viewHolder._moreRv.setLayoutManager(mLayoutManager);
            viewHolder._moreRv.setItemAnimator(new DefaultItemAnimator());
            viewHolder._moreRv.setAdapter(sAdapter1);
            viewHolder._moreRv.setHasFixedSize(true);
        }


        if (!TextUtils.isEmpty(album_pos.getUser_mobile(position))) {
            u_PhoneNo = album_pos.getUser_mobile(position);
        }
        if (!TextUtils.isEmpty(album_pos.getOTP(position))) {
            OTP = album_pos.getOTP(position);
        }


        viewHolder.laterEdit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                if (album_pos.getUnique_ride(position) != null) {
                    from_lat = Double.parseDouble(album_pos.getUser_from_lat(position));
                    from_long = Double.parseDouble(album_pos.getUser_from_long(position));
                    to_lat = Double.parseDouble(album_pos.getUser_to_lat(position));
                    to_long = Double.parseDouble(album_pos.getUser_to_long(position));
                    OTP = album_pos.getOTP(position);
                    _seat = Integer.parseInt(album_pos.getSeat(position));
                    pref.setPickLat(String.valueOf(from_lat));
                    pref.setPickLong(String.valueOf(from_long));
                    pref.setDropLat(String.valueOf(to_lat));
                    pref.setDropLong(String.valueOf(to_long));
                    if (!((Activity) mContext).isFinishing()) {
                        new PostBookdataOffer().execute(String.valueOf(Rate_), album_pos.getUnique_ride(position), album_pos.getUser_mobile(position
                        ));
                    }
                }
            }
        });

        viewHolder.laterCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (album_pos.getUnique_ride(position) != null) {
                    removeAt(position);
                    mContext.stopService(new Intent(mContext, AlarmSoundService.class));
                    mDatabase.child("Driver_Online").child(_PhoneNo).child("Ride").removeValue();
                    Intent o = new Intent(mContext, DrivermapApp.class);
                    o.putExtra("my_lat", My_lat);
                    o.putExtra("my_long", My_long);
                    mContext.startActivity(o);
                    ((Activity) mContext).finish();


                }

            }
        });

    }

    @Override
    public int getItemCount() {
        return mItems.size();
    }

    public void removeAt(int position) {
        mItems.remove(position);
        notifyItemRemoved(position);
        notifyItemRangeChanged(position, mItems.size());

    }


   /* public class FirebaseDataListener_ride implements ValueEventListener {

        @Override
        public void onDataChange(DataSnapshot dataSnapshot) {
            if (dataSnapshot.getChildrenCount()==0) {
                if(pref.getUniqueRide()!=null) {
                    String[] pars = pref.getUniqueRide().split("\\.");
                    con = TextUtils.join("", pars);
                    mDatabase.child(con).child("DriverMobile").setValue(_PhoneNo);
                    mDatabase.child(con).child("Driver_First_Latitude").setValue(dft.format(My_lat));
                    mDatabase.child(con).child("Driver_First_Longitude").setValue(dft.format(My_long));
                    mDatabase.child(con).child("DriversMobile").setValue(u_PhoneNo);
                    mDatabase.child(con).child("Book_To_Latitude").setValue(dft.format(to_lat));
                    mDatabase.child(con).child("Book_To_Longitude").setValue(dft.format(to_long));
                    mDatabase.child(con).child("driverAccept").setValue("YES");
                    mDatabase.child(con).child("driverName").setValue(pref.getName());
                    mDatabase.child(con).child("driverImage").setValue(pref.getProfile());
                    mDatabase.child(con).child("driverVehicle").setValue(pref.getVehicleNo());
                    mDatabase.child(con).child("Book_From_Latitude").setValue(dft.format(from_lat));
                    mDatabase.child(con).child("Book_From_Longitude").setValue(dft.format(from_long));
                    mDatabase.child(con).child("Rating").setValue(String.valueOf(pref.getStar()));
                    mDatabase.child(con).child("OTP").setValue(OTP);

                    if(pref.getvType()==0) {
                        mDatabase.child(con).child("ask").setValue("1");
                        mDatabase.child(con).child("Cost").setValue(String.valueOf(Rate_));
                    }else{
                        mDatabase.child(con).child("ask").setValue("2");
                        mDatabase.child(con).child("Cost").setValue(pref.getCost());
                    }
                    mDatabase.child(con).child("Rate").setValue(String.valueOf(Rate_));
                    mDatabase.child("Ride_Request").child(con).removeValue();

                        mDatabase.child("Driver_Online").child(_PhoneNo).child("OnRide").setValue("YES");
                        mDatabase.child("Driver_Online").child(_PhoneNo).child("Seat").setValue("4");

                        mDatabase.child("Driver_Online").child(_PhoneNo).child("Ride").removeValue();
                        Intent o = new Intent(mContext, GooglemapApp.class);
                        o.putExtra("my_lat", My_lat);
                        o.putExtra("my_long", My_long);
                        mContext.startActivity(o);
                        ((Activity) mContext).finish();
                        ((Activity) mContext).overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);

                }
            }

        }

        @Override
        public void onCancelled(DatabaseError databaseError) {

        }
    }*/

    public class ViewHolder extends RecyclerView.ViewHolder {


        private TextView laterDate, laterTime;
        private EditText inputFrom, inputTo;
        private TextInputLayout inputFromA, inputFromT;
        private Button laterEdit, laterCancel;
        private RecyclerView _moreRv;
        private LinearLayout K1;

        public ViewHolder(View itemView) {
            super(itemView);

            laterDate = itemView.findViewById(R.id.ride_date_later);
            laterTime = itemView.findViewById(R.id.ride_time_later);
            inputFrom = itemView.findViewById(R.id.input_from_address);
            inputTo = itemView.findViewById(R.id.input_to_address);
            inputFromA = itemView.findViewById(R.id.input_from);
            inputFromT = itemView.findViewById(R.id.input_to);
            laterEdit = itemView.findViewById(R.id.ride_later_edit);
            laterCancel = itemView.findViewById(R.id.ride_later_cancel);
            _moreRv = itemView.findViewById(R.id.moreRv);
            K1 = itemView.findViewById(R.id._k1);
        }

    }

    private class PostBookdataOffer extends AsyncTask<String, Integer, String> {


        private boolean success;
        private String _rate, iunique, DriversM;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        protected String doInBackground(String... args) {
            _rate = args[0];
            iunique = args[1];
            DriversM = args[2];
            return uploadFile(_rate, iunique, DriversM);
        }

        private String uploadFile(String args, String args1, String args2) {
            // TODO Auto-generated method stub
            String res = null;

            try {

                RequestBody requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("drivermobile", _PhoneNo)
                        .addFormDataPart("Driversmobile", args2)
                        .addFormDataPart("otp", args1)
                        .addFormDataPart("cost", args)
                        .build();

                Request request = new Request.Builder()
                        .url(com.liteafrica.izigourmet.Config_URL.BOOKING_RIDE_DRIVER)
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
                pref.setUniqueRide(iunique);
                String[] pars = pref.getUniqueRide().split("\\.");
                con = TextUtils.join("", pars);
                u_PhoneNo = DriversM;
                mDatabase.child(con).child("DriverMobile").setValue(_PhoneNo);
                mDatabase.child(con).child("Driver_First_Latitude").setValue(dft.format(My_lat));
                mDatabase.child(con).child("Driver_First_Longitude").setValue(dft.format(My_long));
                mDatabase.child(con).child("DriversMobile").setValue(u_PhoneNo);
                mDatabase.child(con).child("Book_To_Latitude").setValue(dft.format(to_lat));
                mDatabase.child(con).child("Book_To_Longitude").setValue(dft.format(to_long));
                mDatabase.child(con).child("driverAccept").setValue("YES");
                mDatabase.child(con).child("driverName").setValue(pref.getName());
                mDatabase.child(con).child("driverImage").setValue(pref.getProfile());
                mDatabase.child(con).child("driverVehicle").setValue(pref.getVehicleNo());
                mDatabase.child(con).child("Book_From_Latitude").setValue(dft.format(from_lat));
                mDatabase.child(con).child("Book_From_Longitude").setValue(dft.format(from_long));
                mDatabase.child(con).child("Rating").setValue(String.valueOf(pref.getStar()));
                mDatabase.child(con).child("OTP").setValue(OTP);


                mDatabase.child(con).child("ask").setValue("2");
                mDatabase.child(con).child("Cost").setValue(pref.getCost());

                mDatabase.child(con).child("Rate").setValue(String.valueOf(Rate_));
                mDatabase.child("Ride_Request_1").child(con).removeValue();

                mDatabase.child("Driver_Online").child(_PhoneNo).child("OnRide").setValue("YES");
                mDatabase.child("Driver_Online").child(_PhoneNo).child("Seat").setValue("4");

                mDatabase.child("Driver_Online").child(_PhoneNo).child("Ride").removeValue();
                Intent o = new Intent(mContext, DrivermapApp.class);
                mContext.startActivity(o);
                ((Activity) mContext).finish();
                ((Activity) mContext).overridePendingTransition(R.anim.slide_out2, R.anim.slide_in2);


            } else {
                Toast.makeText(mContext, "Please check network!", Toast.LENGTH_SHORT).show();
            }

        }

    }
}





