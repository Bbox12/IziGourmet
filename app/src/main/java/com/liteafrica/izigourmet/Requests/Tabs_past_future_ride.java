package com.liteafrica.izigourmet.Requests;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;
import androidx.viewpager.widget.ViewPager;

import com.google.android.material.tabs.TabLayout;
import com.liteafrica.izigourmet.Activites.Canteen.Canteen_Mainactivity;
import com.liteafrica.izigourmet.R;

import java.util.ArrayList;
import java.util.List;

public class Tabs_past_future_ride extends AppCompatActivity {

    private Toolbar toolbar;
    private TabLayout tabLayout;
    private ViewPager viewPager;
    private double My_lat = 0, My_long = 0;
    private Bundle bundle;
    private int Pager = 0;
    private com.liteafrica.izigourmet.PrefManager pref;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ride_later_tab);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        toolbar = findViewById(R.id.toolbar_later_tabs);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(false);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        viewPager = findViewById(R.id.viewpager_tabs);

        tabLayout = findViewById(R.id.tabs);
        tabLayout.setupWithViewPager(viewPager);


        setupViewPager(viewPager, bundle);

        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (!Tabs_past_future_ride.this.isFinishing()) {
                    AlertDialog.Builder builder = new AlertDialog.Builder(Tabs_past_future_ride.this, R.style.AlertDialogTheme)
                            .setIcon(R.mipmap.ic_launcher)
                            .setTitle("Are you sure to exit?")
                            .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {
                                    overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                    finishAffinity();
                                    finish();
                                    dialog.cancel();
                                }
                            })
                            .setNegativeButton("No", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {
                                    dialog.cancel();
                                }
                            });
                    builder.show();
                }

            }
        });

        if (Pager != 0) {
            viewPager.setCurrentItem(1);
        }

    }

    private void setupViewPager(ViewPager viewPager, Bundle bundle) {
        ViewPagerAdapter adapter = new ViewPagerAdapter(getSupportFragmentManager());
        Future_fragment fragObj1 = new Future_fragment();
        fragObj1.setArguments(bundle);
        adapter.addFragment(fragObj1, "New Orders");
        PastFragment fragobj2 = new PastFragment();
        fragobj2.setArguments(bundle);
        adapter.addFragment(fragobj2, "Accpted Orders");
        ConfirmFragment fragobj3 = new ConfirmFragment();
        fragobj3.setArguments(bundle);
        adapter.addFragment(fragobj3, "Confirm Orders");
        AssignETR fragobj4 = new AssignETR();
        fragobj4.setArguments(bundle);
        adapter.addFragment(fragobj4, "Assign ETR");
        OntheWay fragobj5 = new OntheWay();
        fragobj5.setArguments(bundle);
        adapter.addFragment(fragobj5, "On the way");
        viewPager.setAdapter(adapter);
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        //replaces the default 'Back' button action
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            if (!Tabs_past_future_ride.this.isFinishing()) {
                AlertDialog.Builder builder = new AlertDialog.Builder(Tabs_past_future_ride.this, R.style.AlertDialogTheme)
                        .setIcon(R.mipmap.ic_launcher)
                        .setTitle("Are you sure to exit?")
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
                                finishAffinity();
                                finish();
                                dialog.cancel();
                            }
                        })
                        .setNegativeButton("No", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                dialog.cancel();
                            }
                        });
                builder.show();
            }
        }
        return true;
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
                pref.createLogin(null, null);
                pref.setResponsibility(0);
                pref.packagesharedPreferences(null);
                pref.set_food_money(0);
                pref.setTotal(null);
                pref.setTotal2(null);
                pref.setUniqueRide(null);
                pref.packagesharedPreferences(null);
                pref.set_food_items(0);
                pref.set_food_money(0);
                pref.set_ride(0);
                pref.set_cID(0);
                pref.setPickAt1(null);
                pref.setDropAt1(null);
                pref.set_food_money(0);
                pref.set_food_items(0);
                pref.setPickLat1(null);
                pref.setPickLong1(null);
                pref.setOrder(null);
                pref.setCanteen(null);
                pref.setcName(null);
                pref.setcPhoto(null);
                pref.setcAddress(null);
                pref.setcDiscount(0);
                pref.setcPackaging(0);
                pref.setcLess(null);
                pref.setcMore(null);
                pref.setDelivery(0);
                pref.setGoTRide(0);
                pref.setTotal(null);
                pref.setTotal2(null);
                pref.setadTetxt(null);
                pref.setPayment(0);
                Intent i = new Intent(Tabs_past_future_ride.this, Canteen_Mainactivity.class);
                startActivity(i);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    class ViewPagerAdapter extends FragmentPagerAdapter {
        private final List<Fragment> mFragmentList = new ArrayList<>();
        private final List<String> mFragmentTitleList = new ArrayList<>();

        public ViewPagerAdapter(FragmentManager manager) {
            super(manager);
        }

        @Override
        public Fragment getItem(int position) {
            return mFragmentList.get(position);
        }

        @Override
        public int getCount() {
            return mFragmentList.size();
        }

        public void addFragment(Fragment fragment, String title) {
            mFragmentList.add(fragment);
            mFragmentTitleList.add(title);
        }

        @Override
        public CharSequence getPageTitle(int position) {
            return mFragmentTitleList.get(position);
        }
    }

}
