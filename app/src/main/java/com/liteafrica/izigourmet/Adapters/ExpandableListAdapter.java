package com.liteafrica.izigourmet.Adapters;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseExpandableListAdapter;
import android.widget.Button;
import android.widget.TextView;

import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkError;
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.snackbar.Snackbar;
import com.liteafrica.izigourmet.Activites.Ride_Later.PastRides;
import com.liteafrica.izigourmet.Model.Foods;
import com.liteafrica.izigourmet.Model.User;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class ExpandableListAdapter extends BaseExpandableListAdapter {

    SimpleDateFormat sdf = new SimpleDateFormat("hh:mm aa", Locale.US);
    SimpleDateFormat format = new SimpleDateFormat("HH:mm:ss");
    private Context _context;
    private List<String> _listDataHeader; // header titles
    private HashMap<String, ArrayList<User>> _listDataChild;
    private TextView laterDate, laterTime;
    private RecyclerView morerv;
    private Button Ride_cost;
    private com.liteafrica.izigourmet.PrefManager pref;
    private CoordinatorLayout coordinatorLayout;

    public ExpandableListAdapter(Context context, List<String> listDataHeader,
                                 HashMap<String, ArrayList<User>> listChildData) {
        this._context = context;
        this._listDataHeader = listDataHeader;
        this._listDataChild = listChildData;
    }

    @Override
    public Object getChild(int groupPosition, int childPosititon) {
        return this._listDataChild.get(this._listDataHeader.get(groupPosition))
                .get(childPosititon);
    }

    @Override
    public long getChildId(int groupPosition, int childPosition) {
        return childPosition;
    }

    @Override
    public View getChildView(int groupPosition, final int childPosition,
                             boolean isLastChild, View convertView, ViewGroup parent) {

        final User album_pos = (User) getChild(groupPosition, childPosition);

        if (convertView == null) {
            LayoutInflater infalInflater = (LayoutInflater) this._context
                    .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = infalInflater.inflate(R.layout.later_rv, null);
        }
        laterDate = convertView.findViewById(R.id.ride_date_later);
        laterTime = convertView.findViewById(R.id.ride_time_later);
        morerv = convertView.findViewById(R.id.moreRv);
        Ride_cost = convertView.findViewById(R.id.details);
        DecimalFormat dft = new DecimalFormat("0.00");
        Calendar cal = Calendar.getInstance();

        TextView _status = convertView.findViewById(R.id.status);
        if (album_pos.getDelivered(childPosition) == 0) {
            _status.setText("Pending");
        }
        if (album_pos.getDelivered(childPosition) == 1) {
            _status.setText("Accepted");
        }
        if (album_pos.getDelivered(childPosition) == 2) {
            _status.setText("Confirmed");
        }
        if (album_pos.getDelivered(childPosition) == 3) {
            _status.setText("ETA updated");
        }
        if (album_pos.getDelivered(childPosition) == 4) {
            _status.setText("Dispatched");
        }
        if (album_pos.getDelivered(childPosition) == 5) {
            _status.setText("Delivered");
        }
        if (album_pos.getDelivered(childPosition) == 6) {
            _status.setText("Canceled");
        }

        TextView pending = convertView.findViewById(R.id.pending);

        if (album_pos.getPaymentMode(childPosition) == 1) {
            if (album_pos.getIs_Paid(childPosition) == 1) {
                pending.setText(" COD, PAID");
            }
        } else if (album_pos.getPaymentMode(childPosition) == 2) {
            if (album_pos.getPaymentVerified(childPosition) == 0) {
                pending.setText("EFT PAYMENT PENDING");
            } else {
                pending.setText("EFT PAYMENT DONE");
            }
        }
        if (album_pos.getPaymentMode(childPosition) == 0) {

            pending.setText("PAYMENT NOT SELECTED");

        }

        if (!TextUtils.isEmpty(album_pos.getEnd_date(childPosition)) && !album_pos.getEnd_date(childPosition).contains("null")) {
            String date_ = parseDateToddMMyyyy(album_pos.getEnd_date(childPosition));
            laterDate.setText(date_);

        } else {
            laterDate.setVisibility(View.GONE);
        }
        if (!TextUtils.isEmpty(album_pos.getEnd_time(childPosition))) {
            try {
                Date date = format.parse(album_pos.getEnd_time(childPosition));
                cal.setTime(date);
                laterTime.setText("At " + sdf.format(cal.getTime()));
            } catch (ParseException e) {
                e.printStackTrace();
            }


        } else {
            laterTime.setVisibility(View.GONE);
        }


        go(_context, album_pos.getOrderID(childPosition), morerv);

        Ride_cost.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent o = new Intent(_context, PastRides.class);
                o.putExtra("unique", album_pos.getOrderID(childPosition));
                _context.startActivity(o);
                ((Activity) _context).overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            }
        });
        return convertView;
    }

    @Override
    public int getChildrenCount(int groupPosition) {
        return this._listDataChild.get(this._listDataHeader.get(groupPosition))
                .size();
    }

    @Override
    public Object getGroup(int groupPosition) {
        return this._listDataHeader.get(groupPosition);
    }

    @Override
    public int getGroupCount() {
        return this._listDataHeader.size();
    }

    @Override
    public long getGroupId(int groupPosition) {
        return groupPosition;
    }

    @Override
    public View getGroupView(int groupPosition, boolean isExpanded,
                             View convertView, ViewGroup parent) {
        String headerTitle = (String) getGroup(groupPosition);
        if (convertView == null) {
            LayoutInflater infalInflater = (LayoutInflater) this._context
                    .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = infalInflater.inflate(R.layout.list_group, null);
        }

        TextView lblListHeader = convertView
                .findViewById(R.id.lblListHeader);
        lblListHeader.setTypeface(null, Typeface.BOLD);
        lblListHeader.setText("Order ID :- " + headerTitle);

        return convertView;
    }

    @Override
    public boolean hasStableIds() {
        return false;
    }

    @Override
    public boolean isChildSelectable(int groupPosition, int childPosition) {
        return true;
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

    public void setPref(com.liteafrica.izigourmet.PrefManager pref1) {
        pref = pref1;
    }

    public void setCoordinatorlayout(CoordinatorLayout coordinatorLayout1) {
        coordinatorLayout = coordinatorLayout1;
    }

    private void go(final Context mContext, final String itemmenu, final RecyclerView hadapter1) {

        final ArrayList<Foods> mItems = new ArrayList<Foods>();
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_FOODSS,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        Log.e("submenu", response);
                        try {

                            JSONObject jsonObj = new JSONObject(response);
                            JSONArray Eat = jsonObj.getJSONArray("bookings");
                            if (Eat.length() != 0) {
                                for (int i = 0; i < Eat.length(); i++) {
                                    JSONObject c = Eat.getJSONObject(i);
                                    if (!c.isNull("Price")) {
                                        Foods items = new Foods();
                                        items.setID(c.getInt("ID"));
                                        items.setNoofItems(c.getInt("NoofItems"));
                                        items.seteTEZ_Price((c.getInt("NoofItems") * c.getDouble("Price")) - (c.getInt("NoofItems") * c.getDouble("Discount")));
                                        items.setDiscount(c.getDouble("Discount"));
                                        items.setMenu_Name(c.getString("Name"));
                                        items.setPhoto(c.getString("Photo"));
                                        mItems.add(items);
                                    }
                                }

                            }


                        } catch (final JSONException e) {
                            Log.e("HI", "Json parsing error: " + e.getMessage());


                        }


                        BookingAdapter sAdapter1 = new BookingAdapter(mContext, mItems);
                        sAdapter1.notifyDataSetChanged();
                        sAdapter1.setPref(pref);
                        sAdapter1.setFrom(1);
                        LinearLayoutManager mLayoutManager = new LinearLayoutManager(mContext, LinearLayoutManager.VERTICAL, false);
                        hadapter1.setLayoutManager(mLayoutManager);
                        hadapter1.setItemAnimator(new DefaultItemAnimator());
                        hadapter1.setAdapter(sAdapter1);
                        hadapter1.setHasFixedSize(true);

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d("uuu", "Error: " + error.getMessage());
                if (error instanceof TimeoutError || error instanceof NoConnectionError) {
                    Snackbar snackbar = Snackbar
                            .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_INDEFINITE)
                            .setAction("Refresh", new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {

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
                params.put("submenu", itemmenu);
                return params;
            }

        };
        com.liteafrica.izigourmet.AppController.getInstance().addToRequestQueue(eventoReq);

    }


}
