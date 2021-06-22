package com.liteafrica.izigourmet.Activites.Canteen;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.CompoundButton;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatCheckBox;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;

import com.liteafrica.izigourmet.R;

import java.util.HashMap;

public class Payment extends AppCompatActivity implements View.OnClickListener {
    private CoordinatorLayout coordinatorLayout;
    private Toolbar toolbar;
    private com.liteafrica.izigourmet.PrefManager pref;
    private String _phoneNo;
    private AppCompatCheckBox _cash;
    private int paymentmode = 0;
    private ProgressDialog mProgressDialog = null;

    @Override
    public void onClick(View view) {
        switch (view.getId()) {

            case R.id.finalsubmit:
                //  go();
                break;
            default:
                break;
        }


    }


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.payment);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        HashMap<String, String> user = pref.getUserDetails();
        _phoneNo = user.get(com.liteafrica.izigourmet.PrefManager.KEY_MOBILE);
        coordinatorLayout = findViewById(R.id
                .cor_home_main);
        toolbar = findViewById(R.id.toolbardd);
        setSupportActionBar(toolbar);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        toolbar.setTitle("Payment");

        Button finalsubmit = findViewById(R.id.finalsubmit);
        finalsubmit.setOnClickListener(this);

        _cash = findViewById(R.id.cash);


        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {


                Intent o = new Intent(Payment.this, SelectePaymentOption.class);
                startActivity(o);
                finish();
                overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);


            }

        });


    }


    @Override
    protected void onResume() {
        super.onResume();
        _cash.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
                if (b) {
                    paymentmode = 1;

                }
            }
        });

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_save, menu);
        return true;

    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        return super.onOptionsItemSelected(item);
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        //replaces the default 'Back' button action
        if (keyCode == KeyEvent.KEYCODE_BACK) {


            Intent i = new Intent(Payment.this, SelectePaymentOption.class);
            startActivity(i);
            finish();
            overridePendingTransition(R.anim.slide_up1, R.anim.rbounce);


        }
        return true;
    }

    @Override
    protected void onStop() {
        super.onStop();
        if (!Payment.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
    }

    @Override
    protected void onPause() {
        super.onPause();
        if (!Payment.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (!Payment.this.isFinishing()) {
            if (mProgressDialog != null) {
                mProgressDialog.dismiss();
            }
        }
    }
}
