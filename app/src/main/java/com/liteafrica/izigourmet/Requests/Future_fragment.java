package com.liteafrica.izigourmet.Requests;

import android.content.Context;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ExpandableListView;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
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
import com.liteafrica.izigourmet.AppController;
import com.liteafrica.izigourmet.Model.User;
import com.liteafrica.izigourmet.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;


/**
 * Created by parag on 27/01/18.
 */

public class Future_fragment extends Fragment {
    private static final String TAG = Future_fragment.class.getSimpleName();
    private ProgressBar progressBar;
    private RecyclerView laterRv;
    private ArrayList<User> mItems = new ArrayList<User>();
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _PhoneNo;
    private double My_lat = 0, My_long = 0;
    private Button Datesadd;
    private TextView no_rides;
    private ExpandableListView expListView;
    private listOrdersRv listAdapter;
    private CoordinatorLayout coordinatorLayout;

    public Future_fragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View V = inflater.inflate(R.layout.orderfragments, container, false);
        expListView = V.findViewById(R.id.lvExp);
        no_rides = V.findViewById(R.id.textView104);
        progressBar = V.findViewById(R.id.progressBar21);
        progressBar.setVisibility(View.VISIBLE);
        coordinatorLayout = V.findViewById(R.id
                .cor_home_main);
        pref = new com.liteafrica.izigourmet.PrefManager(getActivity());
        HashMap<String, String> user = pref.getUserDetails();
        _PhoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        return V;
    }


    @Override
    public void onAttach(Context context) {
        super.onAttach(context);


    }

    @Override
    public void onResume() {
        super.onResume();
        getOrders();
    }


    private void getOrders() {
        final ArrayList<String> listDataHeader = new ArrayList<String>();

        final HashMap<String, ArrayList<User>> listDataChild = new HashMap<String, ArrayList<User>>();
        StringRequest eventoReq = new StringRequest(com.android.volley.Request.Method.POST, com.liteafrica.izigourmet.Config_URL.GET_MENU,
                new Response.Listener<String>() {


                    @Override
                    public void onResponse(String response) {

                        Log.w("futureorders", response);
                        try {


                            JSONObject jsonObj = new JSONObject(response);
                            JSONArray bookings = jsonObj.getJSONArray("first");
                            for (int i = 0; i < bookings.length(); i++) {
                                JSONObject c = bookings.getJSONObject(i);
                                ArrayList<User> mItems = new ArrayList<User>();
                                User item = new User();
                                item.setEnd_time(c.getString("End_Time"));
                                item.setEnd_date(c.getString("End_Date"));
                                item.setCost(c.getString("Cost"));
                                item.setOrderID(c.getString("OrderID"));
                                listDataHeader.add("Area: "+c.getString("From_area")+"\n"+"Order ID :- "+c.getString("OrderID"));
                                item.setDelivered(c.getInt("Delivered"));
                                item.setpCost(c.getString("pCost"));
                                item.setTime(c.getString("ETR"));
                                item.setPaymentVerified(c.getInt("PaymentVerified"));
                                item.setPaymentMode(c.getInt("PaymentMode"));
                                item.setIs_Paid(c.getInt("Is_Paid"));
                                mItems.add(item);
                                listDataChild.put("Area: "+c.getString("From_area")+"\n"+"Order ID :- "+c.getString("OrderID"), mItems);
                            }
                            if (listDataChild.size() != 0) {
                                listAdapter = new listOrdersRv(getActivity(), listDataHeader, listDataChild);
                                listAdapter.setPref(pref);
                                listAdapter.setCoordinatorlayout(coordinatorLayout);
                                expListView.setAdapter(listAdapter);
                                expListView.setVisibility(View.VISIBLE);
                                no_rides.setVisibility(View.GONE);
                                progressBar.setVisibility(View.GONE);
                            } else {
                                expListView.setVisibility(View.GONE);
                                no_rides.setVisibility(View.VISIBLE);
                                progressBar.setVisibility(View.GONE);
                            }

                        } catch (final JSONException e) {
                            Log.e("HI", "Json parsing error: " + e.getMessage());
                        }


                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d("uuu", "Error: " + error.getMessage());
                vollyError(error);


            }

        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("_mId", _PhoneNo);
                return params;
            }

        };
        eventoReq.setRetryPolicy(new DefaultRetryPolicy(
                0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        AppController.getInstance().addToRequestQueue(eventoReq);
    }

    private void vollyError(VolleyError error) {
        if (error instanceof TimeoutError || error instanceof NoConnectionError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        } else if (error instanceof AuthFailureError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network is unreachable. Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        } else if (error instanceof ServerError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Server Error.Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        } else if (error instanceof NetworkError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Network Error. Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        } else if (error instanceof ParseError) {

            Snackbar snackbar = Snackbar
                    .make(coordinatorLayout, "Data Error. Please try another time", Snackbar.LENGTH_SHORT);
            snackbar.setActionTextColor(Color.RED);
                                snackbar.setTextColor(Color.WHITE);
            snackbar.show();

        }
    }

}
