package com.liteafrica.izigourmet.Adapters;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.liteafrica.izigourmet.Activites.Canteen.ProductDetailsPage;
import com.liteafrica.izigourmet.Model.Eats;
import com.liteafrica.izigourmet.R;

import java.util.ArrayList;

public class _CommodityAdapter extends RecyclerView.Adapter<_CommodityAdapter.ViewHolder> {

    private ArrayList<Eats> mItems;
    private Context mContext;
    private ImageLoader imageLoader;
    private int _from = 0;
    private CoordinatorLayout coordinatorLayout;
    private String _phoneNo;
    private com.liteafrica.izigourmet.PrefManager pref;


    public _CommodityAdapter(Context aContext, ArrayList<Eats> mItems) {
        this.mItems = mItems;
        this.mContext = aContext;

    }

    public void setPref(com.liteafrica.izigourmet.PrefManager pref1) {
        pref = pref1;
    }

    @Override
    public long getItemId(int position) {
        return super.getItemId(position);
    }

    @Override
    public int getItemViewType(int position) {
        return super.getItemViewType(position);
    }


    @Override
    public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        //More to come
        View v = LayoutInflater.from(viewGroup.getContext())
                .inflate(R.layout.commodityrv, viewGroup, false);

        return new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(final ViewHolder viewHolder, final int position) {
        final Eats album_pos = mItems.get(position);

        if (album_pos.getName(position) != null && !TextUtils.isEmpty(album_pos.getName(position))) {
            viewHolder.Name.setText(album_pos.getName(position));
            viewHolder.Name.setBackgroundColor(Color.parseColor(album_pos.getColors(position)));
        }


        String url = album_pos.getPhoto(position).replaceAll(" ", "%20");
        ImageLoader imageLoader = com.liteafrica.izigourmet.LruBitmapCache.getInstance(mContext)
                .getImageLoader();
        imageLoader.get(url, ImageLoader.getImageListener(viewHolder.Thumbnail,
                R.mipmap.ic_launcher, R.mipmap
                        .ic_launcher));
        viewHolder.Thumbnail.setImageUrl(url, imageLoader);

        viewHolder.Thumbnail.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent o = new Intent(mContext, ProductDetailsPage.class);
                pref.setPref1(2);
                pref.setID3(album_pos.getID(position));
                mContext.startActivity(o);
                //  ((Activity) mContext).finish();
                ((Activity) mContext).overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            }
        });
    }


    @Override
    public int getItemCount() {
        return mItems.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {


        private TextView Name;
        private NetworkImageView Thumbnail;


        public ViewHolder(View itemView) {
            super(itemView);
            Name = itemView.findViewById(R.id.primary_text);
            Thumbnail = itemView.findViewById(R.id.service_pic);
        }

    }


}






