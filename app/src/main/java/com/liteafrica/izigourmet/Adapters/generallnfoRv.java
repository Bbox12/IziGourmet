package com.liteafrica.izigourmet.Adapters;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.ImageView;
import android.widget.RadioButton;
import android.widget.TextView;

import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.liteafrica.izigourmet.Model.Contacts;
import com.liteafrica.izigourmet.R;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;


/**
 * Created by parag on 22/09/16.
 */
public class generallnfoRv extends RecyclerView.Adapter<generallnfoRv.ViewHolder> {

    // The items to display in your RecyclerView
    private ArrayList<Contacts> mItems;
    private LayoutInflater layoutInflater;
    private Context mContext;
    private String Mobile;
    private double My_lat = 0, My_long = 0;
    private String Mode;
    private int _from = 0;


    public generallnfoRv(Context aContext, ArrayList<Contacts> mItems) {
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

    public void setMode(String mode) {
        Mode = mode;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        //More to come
        View v = LayoutInflater.from(viewGroup.getContext())
                .inflate(R.layout.class_rv, viewGroup, false);
        ViewHolder viewHolder = new ViewHolder(v);

        return viewHolder;
    }

    @Override
    public void onBindViewHolder(final ViewHolder viewHolder, final int position) {
        final Contacts album_pos = mItems.get(position);


        if (album_pos.getPhoto(position) != null && !TextUtils.isEmpty(album_pos.getPhoto(position))
        ) {
            viewHolder._Image1.setVisibility(View.VISIBLE);

            viewHolder._Image1.setBackground(mContext.getResources().getDrawable(R.mipmap.ic_hwimage));
        } else {
            viewHolder._Image1.setVisibility(View.GONE);
        }


        if (album_pos.getMessage(position) != null && !TextUtils.isEmpty(album_pos.getMessage(position))
        ) {
            viewHolder.title.setText(album_pos.getMessage(position).toUpperCase());
        } else {
            viewHolder.title.setVisibility(View.GONE);
        }


        viewHolder._date.setVisibility(View.VISIBLE);
        viewHolder._date.setText(parseDateToETR(album_pos.getDate(position) + album_pos.getTime(position)));


        viewHolder._Image1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (!((Activity) mContext).isFinishing()) {
                    final Dialog dialog = new Dialog(mContext, R.style.Theme_AppCompat_DayNight_DialogWhenLarge);
                    dialog.setCancelable(true);
                    dialog.setCanceledOnTouchOutside(true);
                    dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
                    dialog.setContentView(R.layout.full_image);
                    NetworkImageView _Profile = dialog.findViewById(R.id.full_image_view);
                    String url = "http://139.59.38.160/IziGourmet/Dashboard/push/" + album_pos.getPhoto(position);
                    ImageLoader imageLoader = com.liteafrica.izigourmet.LruBitmapCache.getInstance(mContext)
                            .getImageLoader();
                    imageLoader.get(url, ImageLoader.getImageListener(_Profile,
                            R.mipmap.ic_no_image, R.mipmap
                                    .ic_no_image));
                    _Profile.setImageUrl(url, imageLoader);
                    dialog.show();

                }
            }
        });

    }

    @Override
    public int getItemCount() {
        return mItems.size();
    }

    public void setFrom(int i) {
        _from = i;
    }

    public String parseDateToETR(String time) {
        String inputPattern = "yyyy-MM-ddHH:mm:ss";
        String outputPattern = "dd MMM yy hh:mm aa";
        SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
        SimpleDateFormat outputFormat = new SimpleDateFormat(outputPattern);

        Date date = null;
        String str = null;

        try {
            date = inputFormat.parse(time);
            str = outputFormat.format(date);
        } catch (ParseException e) {
            //e.printStackTrace();
            String inputPattern1 = "MM-dd-yyyy";
            String outputPattern1 = "dd MMM yy";
            SimpleDateFormat inputFormat1 = new SimpleDateFormat(inputPattern1);
            SimpleDateFormat outputFormat1 = new SimpleDateFormat(outputPattern1);

            Date date1 = null;

            try {
                date1 = inputFormat1.parse(time);
                str = outputFormat1.format(date1);
            } catch (ParseException e1) {
                e1.printStackTrace();
            }
        }
        return str;
    }

    public class ViewHolder extends RecyclerView.ViewHolder {


        private ImageView _Image1;
        private TextView title, description;
        private RadioButton _date;

        public ViewHolder(View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            description = itemView.findViewById(R.id.description);
            _Image1 = itemView.findViewById(R.id._image_1);
            _date = itemView.findViewById(R.id.date);
        }

    }


}





