package com.liteafrica.izigourmet.Adapters;

import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.TextView;

import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.toolbox.ImageLoader;
import com.google.android.gms.maps.model.LatLng;
import com.liteafrica.izigourmet.Model.Canteens;
import com.liteafrica.izigourmet.PrefManager;
import com.liteafrica.izigourmet.R;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.Date;

public class CanteenAdapter extends RecyclerView.Adapter<CanteenAdapter.MyViewHolder> {

    public String Op_time, Cl_time;
    private Context mContext;
    private ArrayList<Canteens> albumList;
    private String Mn_order;
    private com.liteafrica.izigourmet.PrefManager pref;
    private Date timeToCompare;
    private boolean _closed = false;
    private Date beforeTime;
    private int _time = 0;
    private String Mn_time;
    private String _phoneNo;
    private ImageLoader imageLoader;
    private LatLng latLng;
    private boolean got=false;

    public CanteenAdapter(Context mContext, ArrayList<Canteens> albumList) {
        this.mContext = mContext;
        this.albumList = albumList;
    }


    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View itemView = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.secondcard, parent, false);

        return new MyViewHolder(itemView);
    }

    @Override
    public void onBindViewHolder(final MyViewHolder holder, final int position) {
        _closed = false;
        final Canteens album = albumList.get(position);
        holder.name.setText(album.getName(position));
        holder.address.setText(album.getAddress(position));
        holder.distance.setText("We deliver within a "+String.valueOf(album.getDistance(position))+"Km radius");
        DecimalFormat dft = new DecimalFormat("0.00");
       double d1 = distance(album.getLatitude(position), album.getLongitude(position), latLng.latitude, latLng.longitude);
      //  double d1 = distance(album.getLatitude(position), album.getLongitude(position), -26.1929667,28.0330155);
        holder.totaldistance.setText(dft.format(d1)+" KM");
        Log.e("HI", "Json parsing error: " + String.valueOf(position));
        if(d1>album.getDistance(position)){
            if(position==0 && !got){
                pref.setGoTRide(1);
                holder._chk.setChecked(true);
                holder.conditions.setText("Store pickup only. (Nearest to you)");
                pref.setCanteen(String.valueOf(album.getID(position)));
            }else{
                holder.conditions.setText("Store pickup only");
            }
        }else{
            if(!got) {
                pref.setGoTRide(0);
                got=true;
                holder._chk.setChecked(true);
                pref.setCanteen(String.valueOf(album.getID(position)));
                holder.conditions.setText("Home delivery");
            }
        }



    }

    @Override
    public int getItemCount() {
        return albumList.size();
    }

    public void setLocation(LatLng latLng1) {
        latLng=latLng1;
    }

    public void setPref(PrefManager pref1) {
        pref=pref1;
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        private TextView name,address,distance,totaldistance,conditions;
        private CheckBox _chk;

        public MyViewHolder(View view) {
            super(view);
            name = view.findViewById(R.id.name);
            address = view.findViewById(R.id.address);
            distance = view.findViewById(R.id.distance);
            totaldistance = view.findViewById(R.id.totaldistance);
            conditions = view.findViewById(R.id.condition);
            _chk = view.findViewById(R.id.chk);
        }
    }


    private double distance(double lat1, double lon1, double lat2, double lon2) {
        double theta = lon1 - lon2;
        double dist = Math.sin(deg2rad(lat1))
                * Math.sin(deg2rad(lat2))
                + Math.cos(deg2rad(lat1))
                * Math.cos(deg2rad(lat2))
                * Math.cos(deg2rad(theta));
        dist = Math.acos(dist);
        dist = rad2deg(dist);
        dist = dist * 60 * 1.1515;
        return (dist);
    }

    private double deg2rad(double deg) {
        return (deg * Math.PI / 180.0);
    }

    private double rad2deg(double rad) {
        return (rad * 180.0 / Math.PI);
    }

}