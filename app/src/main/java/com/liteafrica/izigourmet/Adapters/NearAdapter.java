package com.liteafrica.izigourmet.Adapters;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.RatingBar;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.google.android.gms.maps.model.LatLng;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Details;
import com.liteafrica.izigourmet.LruBitmapCache;
import com.liteafrica.izigourmet.Model.Eats;
import com.liteafrica.izigourmet.R;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;

public class NearAdapter extends RecyclerView.Adapter<NearAdapter.ViewHolder> {

    protected List<Eats> list;
    // The items to display in your RecyclerView
    private ArrayList<Eats> mItems;
    private LayoutInflater mshit;

    private Context mContext;
    private int Name_p;
    private String User;
    private String rView;
    private ArrayList<Eats> mModel;
    private LatLng latLng;
    private int _from = 0;
    private DecimalFormat dft = new DecimalFormat("0.00");
    private com.liteafrica.izigourmet.PrefManager pref;
    private int _deals = 0;
    private CoordinatorLayout coordinatorLayout;


    public NearAdapter(Context acontext, ArrayList<Eats> mItems) {
        //mshit = LayoutInflater.from(acontext);
        this.mItems = mItems;
        this.mContext = acontext;


    }


    @Override
    public long getItemId(int position) {

        return super.getItemId(position);
    }

    @Override
    public int getItemViewType(int position) {
        return super.getItemViewType(position);
    }

    public void setLatLong(LatLng latLng1) {
        latLng = latLng1;
    }

    public void setFrom(int from) {
        _from = from;
    }

    public void setPref(com.liteafrica.izigourmet.PrefManager pref1) {
        pref = pref1;
    }

    public void setDeals(int from) {
        _deals = from;
    }

    public void setCoordinate(CoordinatorLayout coordinatorLayout1) {
        coordinatorLayout = coordinatorLayout1;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        View v;

        v = LayoutInflater.from(viewGroup.getContext())
                .inflate(R.layout.nearrv, viewGroup, false);

        return new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(final ViewHolder viewHolder, final int position) {
        final Eats movie = mItems.get(position);


        if (movie.getPhoto(position) != null) {


            String url = movie.getPhoto(position).replaceAll(" ", "%20");
            ImageLoader imageLoader = LruBitmapCache.getInstance(mContext)
                    .getImageLoader();
            imageLoader.get(url, ImageLoader.getImageListener(viewHolder.images_p,
                    R.mipmap.ic_no_image, R.mipmap
                            .ic_no_image));
            viewHolder.images_p.setImageUrl(url, imageLoader);

            if (movie.getName(position) != null && !TextUtils.isEmpty(movie.getName(position))) {
                viewHolder._name.setText(movie.getName(position));
            }

            if (Name_p == 0) {
                double dist2 = com.google.maps.android.SphericalUtil.computeDistanceBetween(new LatLng(movie.getLatitude(position), movie.getLonitude(position)), latLng) / 1000;

                viewHolder._secondarytext.setText(dft.format(dist2) + " Km");

            } else {
                viewHolder._secondarytext.setVisibility(View.GONE);
            }
            if (_deals == 1) {
                viewHolder.discount_1.setVisibility(View.VISIBLE);
                DecimalFormat df = new DecimalFormat("0");
                viewHolder.discount_1.setText(df.format(movie.getDiscount(position)) + "%\noff");
            }
            viewHolder.ratingBar.setRating(Float.parseFloat(String.valueOf(movie.getRating(position))));
            viewHolder.booknow.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    if (pref.get_food_money() != 0) {
                        if (pref.get_cID() != movie.getID(position)) {
                            if (!((Activity) mContext).isFinishing()) {

                                new AlertDialog.Builder(mContext, R.style.AlertDialogTheme)
                                        .setIcon(R.mipmap.ic_launcher)
                                        .setTitle("Your already have an incomplete order with shop " + pref.getName())
                                        .setMessage("Do you want to cancel order?")
                                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                                            @Override
                                            public void onClick(DialogInterface dialog, int which) {
                                                pref.setDropAt1(null);
                                                pref.setPickAt1(null);
                                                pref.setPickLat1(null);
                                                pref.setPickLong1(null);
                                                pref.setPickAt1(null);
                                                pref.setDropAt1(null);
                                                pref.set_cID(0);
                                                pref.set_cID1(0);
                                                pref.set_food_money(0);
                                                pref.set_food_items(0);
                                                pref.packagesharedPreferences(null);
                                                pref.setDelivery(0);
                                                pref.setTotal(null);
                                                pref.setTotal2(null);
                                                pref.set_cID(movie.getID(position));
                                                pref.setName(movie.getName(position));
                                                Intent o = new Intent(mContext, Canteen_Details.class);
                                                mContext.startActivity(o);
                                                ((Activity) mContext).finish();
                                                ((Activity) mContext).overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                                dialog.cancel();
                                            }
                                        })
                                        .setNegativeButton("No", new DialogInterface.OnClickListener() {
                                            @Override
                                            public void onClick(DialogInterface dialogInterface, int i) {
                                                pref.set_cID(movie.getID(position));
                                                pref.setName(movie.getName(position));
                                                Intent o = new Intent(mContext, Canteen_Details.class);
                                                mContext.startActivity(o);
                                                ((Activity) mContext).finish();
                                                ((Activity) mContext).overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                                dialogInterface.cancel();
                                            }
                                        })
                                        .show();
                            }
                        }
                    } else {
                        pref.set_cID(movie.getID(position));
                        pref.setName(movie.getName(position));
                        Intent o = new Intent(mContext, Canteen_Details.class);
                        mContext.startActivity(o);
                        ((Activity) mContext).finish();
                        ((Activity) mContext).overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                    }

                }
            });

        }
    }

    @Override
    public int getItemCount() {
        return mItems.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

        private NetworkImageView images_p;
        private TextView _name, _secondarytext;
        private Button booknow;
        private LinearLayout _L1;
        private RatingBar ratingBar;
        private TextView discount_1;


        public ViewHolder(View itemView) {
            super(itemView);

            images_p = itemView.findViewById(R.id.service_pic);
            _name = itemView.findViewById(R.id.primary_text);
            _secondarytext = itemView.findViewById(R.id.secondary_text);
            booknow = itemView.findViewById(R.id.booknow);
            _L1 = itemView.findViewById(R.id._l1);
            ratingBar = itemView.findViewById(R.id.ratingBar);
        }


    }


}

