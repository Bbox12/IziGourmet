package com.liteafrica.izigourmet.Adapters;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.recyclerview.widget.RecyclerView;

import com.liteafrica.izigourmet.Activites.Canteen.SingleProduct;
import com.liteafrica.izigourmet.Activites.Main_Page.GooglemapApp;
import com.liteafrica.izigourmet.Model.Eats;
import com.liteafrica.izigourmet.PrefManager;
import com.liteafrica.izigourmet.R;
import com.squareup.picasso.Picasso;

import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Locale;
import java.util.Set;


/**
 * Created by parag on 22/09/16.
 */
public class Image_Adapter extends RecyclerView.Adapter<Image_Adapter.ViewHolder> {

    SimpleDateFormat sdf = new SimpleDateFormat("hh:mm aa", Locale.US);
    SimpleDateFormat format = new SimpleDateFormat("HH:mm:ss");
    // The items to display in your RecyclerView
    private ArrayList<Eats> mItems;
    private Context mContext;
    private String Mobile;
    private double My_lat = 0, My_long = 0;
    private CoordinatorLayout coordinatorLayout;
    private PrefManager pref;
    private TextView _iValue;
    private int itemSelected = 0;
    private double _orderValue = 0;
    private DecimalFormat df = new DecimalFormat("0.00");
    private ArrayList<String> _foods = new ArrayList<String>();
    private TextView orders;

    public Image_Adapter(Context aContext, ArrayList<Eats> mItems) {
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

    public void setMobile(String mobile) {
        Mobile = mobile;
    }


    public void setPref(PrefManager pref1) {
        pref = pref1;
    }


    @Override
    public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
        //More to come
        View v = LayoutInflater.from(viewGroup.getContext())
                .inflate(R.layout.welcome_slide1, viewGroup, false);
        ViewHolder viewHolder = new ViewHolder(v);

        return viewHolder;
    }

    public void setCoordinatorlayout(CoordinatorLayout coordinatorLayout1) {
        coordinatorLayout = coordinatorLayout1;
    }


    @Override
    public void onBindViewHolder(final ViewHolder viewHolder, final int position) {
        final Eats album_pos = mItems.get(position);
        DecimalFormat df = new DecimalFormat("0.00");

        if (mItems.size() == 1) {
            viewHolder._next.setVisibility(View.GONE);
        }


        viewHolder.rrr.setVisibility(View.VISIBLE);
        viewHolder.outofstock.setVisibility(View.GONE);


        Picasso.Builder builder = new Picasso.Builder(mContext);
        builder.listener(new Picasso.Listener() {
            @Override
            public void onImageLoadFailed(Picasso picasso, Uri uri, Exception exception) {
                exception.printStackTrace();
            }
        });
        builder.build().load(album_pos.getPhoto(position)).into(viewHolder._image1);
        viewHolder.Description.setText(album_pos.getDescription(position));
        viewHolder.primary_name.setText(album_pos.getName(position));
        if (album_pos.getDiscount(position) != 0) {
            viewHolder.discount_1.setVisibility(View.VISIBLE);
            viewHolder.discountprice_1.setVisibility(View.VISIBLE);
            viewHolder.discount_1.setText("R" + df.format(album_pos.getDiscount(position)) + " off");
            viewHolder.discountprice_1.setText("R" + df.format(album_pos.getPrice(position) + album_pos.getDiscount(position)));
        } else {
            viewHolder.discount_1.setVisibility(View.GONE);
            viewHolder.discountprice_1.setVisibility(View.GONE);
            viewHolder.V1.setVisibility(View.GONE);
            viewHolder.V2.setVisibility(View.GONE);
        }

        viewHolder.price_1.setText("R" + df.format(album_pos.getPrice(position)));

        if (pref.get_packagesharedPreferences() != null) {
            Set<String> set = pref.get_packagesharedPreferences();
            _foods.clear();
            _foods.addAll(set);
            for (String s : set) {
                String[] pars = s.split("\\^");
                if (Integer.parseInt(pars[0]) == album_pos.getID(position)) {
                    viewHolder.rate_km1.setText(pars[1]);
                    break;
                }
            }
        }

        if (pref.get_food_items() != 0) {
            _orderValue = pref.get_food_money();
            pref.set_food_money((float) _orderValue);

        } else {
            pref.set_food_money(0);
        }


        viewHolder._image1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent o = new Intent(mContext, SingleProduct.class);
                pref.setPref2(1);
                pref.setID1(1);
                pref.setID5(album_pos.getID(position));
                mContext.startActivity(o);
                ((Activity) mContext).overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            }
        });


        viewHolder.button2_add1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (pref.getUniqueRide() == null) {
                    boolean _again = false;
                    int Rate_ = Integer.parseInt(viewHolder.rate_km1.getText().toString());
                    Rate_ = 1 + Rate_;
                    int dk = (int) album_pos.getPrice(position);
                    _orderValue = pref.get_food_money() + dk;
                    pref.set_food_money((float) _orderValue);
                    viewHolder.rate_km1.setText(String.valueOf(Rate_));
                    if (pref.get_packagesharedPreferences() != null) {
                        Set<String> set = pref.get_packagesharedPreferences();
                        _foods.clear();
                        _foods.addAll(set);
                    }
                    for (int i = 0; i < _foods.size(); i++) {
                        String[] pars = _foods.get(i).split("\\^");
                        if (album_pos.getID(position) == Integer.parseInt(pars[0])) {
                            String s = pars[0];
                            _foods.remove(i);
                            _again = true;
                            _foods.add(s + "^" + Rate_ + "^" + Rate_ * dk + "^" + album_pos.getName(position) + "^" + album_pos.getPhoto(position));
                        }

                    }
                    if (!_again) {
                        itemSelected = pref.get_food_items();
                        itemSelected = itemSelected + 1;
                        pref.set_food_items(itemSelected);
                        _foods.add(album_pos.getID(position) + "^" + 1 + "^" + dk + "^" + album_pos.getName(position) + "^" + album_pos.getPhoto(position));
                    }
                    pref.packagesharedPreferences(_foods);
                    orders.setText(String.valueOf(pref.get_food_items()));

                } else {
                    if (!((Activity) mContext).isFinishing()) {
                        new AlertDialog.Builder(mContext, R.style.AlertDialogTheme)
                                .setTitle("Your order is already in process")
                                .setMessage("Please check the status of your order")
                                .setPositiveButton("Check", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(mContext, GooglemapApp.class);
                                        pref.set_ride(3);
                                        mContext.startActivity(o);
                                        ((Activity) mContext).overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
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
        });


        viewHolder.button2_minus1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (pref.getUniqueRide() == null) {
                    int Rate_2 = Integer.parseInt(viewHolder.rate_km1.getText().toString());
                    if (Rate_2 > 0) {
                        Rate_2 = Rate_2 - 1;
                        viewHolder.rate_km1.setText(String.valueOf(Rate_2));
                        int jk = (int) album_pos.getPrice(position);
                        _orderValue = pref.get_food_money() - jk;
                        pref.set_food_money((float) _orderValue);
                        if (pref.get_packagesharedPreferences() != null) {
                            Set<String> set = pref.get_packagesharedPreferences();
                            _foods.clear();
                            _foods.addAll(set);
                        }
                        for (int i = 0; i < _foods.size(); i++) {
                            String[] pars = _foods.get(i).split("\\^");
                            if (pref.getID2() == Integer.parseInt(pars[0])) {
                                String s = pars[0];
                                _foods.remove(i);
                                _foods.add(s + "^" + Rate_2 + "^" + Rate_2 * jk + "^" + album_pos.getName(position) + "^" + album_pos.getPhoto(position));

                            }

                        }
                        pref.packagesharedPreferences(_foods);
                    }

                    if (Rate_2 == 0) {
                        viewHolder.rate_km1.setText("0");
                        for (int i = 0; i < _foods.size(); i++) {
                            String[] pars = _foods.get(i).split("\\^");
                            if (album_pos.getID(position) == Integer.parseInt(pars[0])) {
                                _foods.remove(i);

                                itemSelected = pref.get_food_items();
                                itemSelected = itemSelected - 1;
                                pref.set_food_items(itemSelected);
                                orders.setText(String.valueOf(pref.get_food_items()));
                            }

                        }
                        pref.packagesharedPreferences(_foods);
                        if (itemSelected == 0) {
                            pref.packagesharedPreferences(null);
                            pref.set_food_money(0);
                            pref.set_food_items(0);
                            pref.setTotal(null);
                            pref.setTotal2(null);
                        }
                    }

                } else {
                    if (!((Activity) mContext).isFinishing()) {
                        new AlertDialog.Builder(mContext, R.style.AlertDialogTheme)
                                .setTitle("Your order is already in process")
                                .setMessage("Please check the status of your order")
                                .setPositiveButton("Check", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        dialog.cancel();
                                        Intent o = new Intent(mContext, GooglemapApp.class);
                                        pref.set_ride(3);
                                        mContext.startActivity(o);
                                        ((Activity) mContext).overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
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
        });


    }

    @Override
    public int getItemCount() {
        return mItems.size();
    }

    public String parseDateToddMMyyyy(String time) {
        String inputPattern = "yyyy-MM-dd";
        String outputPattern = "dd MMM yy";
        SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
        SimpleDateFormat outputFormat = new SimpleDateFormat(outputPattern);

        Date date = null;
        String str = null;

        try {
            date = inputFormat.parse(time);
            str = outputFormat.format(date);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        return str;
    }

    public void setNos(TextView orders1) {
        orders = orders1;
    }

    public class ViewHolder extends RecyclerView.ViewHolder {


        private TextView Description, discount_1, price_1, discountprice_1, rate_km1, primary_name;
        private ImageView _image1, _next;
        private TextView Ride_cost, outofstock;
        private Button first_button;
        private LinearLayout rrr;
        private ImageButton button2_add1, button2_minus1;
        private View V1,V2;

        public ViewHolder(View itemView) {
            super(itemView);


            Description = itemView.findViewById(R.id.primary_text);
            discount_1 = itemView.findViewById(R.id.discount_1);
            price_1 = itemView.findViewById(R.id.price_1);
            discountprice_1 = itemView.findViewById(R.id.discountprice_1);
            _image1 = itemView.findViewById(R.id.wlcm1);
            _next = itemView.findViewById(R.id._image1);
            button2_add1 = itemView.findViewById(R.id.button2_add1);
            button2_minus1 = itemView.findViewById(R.id.button2_minus1);
            rate_km1 = itemView.findViewById(R.id.rate_km1);
            primary_name = itemView.findViewById(R.id.primary_name);
            outofstock = itemView.findViewById(R.id.outofstock);
            rrr = itemView.findViewById(R.id._rrr1);
            V1 = itemView.findViewById(R.id.V1);
            V2 = itemView.findViewById(R.id.V2);
        }

    }


}





