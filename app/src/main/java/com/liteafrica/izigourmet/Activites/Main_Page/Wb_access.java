package com.liteafrica.izigourmet.Activites.Main_Page;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import com.liteafrica.izigourmet.R;


public class Wb_access extends Activity {

    private WebView webView;
    private String postUrl;
    private double My_lat, My_long;
    private com.liteafrica.izigourmet.PrefManager pref;


    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent i = getIntent();
        My_lat = i.getDoubleExtra("my_lat", 0);
        My_long = i.getDoubleExtra("my_long", 0);
        pref = new com.liteafrica.izigourmet.PrefManager(getApplicationContext());
        if (postUrl == null) {
            postUrl = "http://139.59.38.160/eTez/latlongFCM.php?lat=" + My_lat + "&long=" + My_long + "&unique=" + pref.getCon() + "&Seat=" + pref.getisShare();
        }

        setContentView(R.layout.web_access);

        webView = findViewById(R.id.webView);
        webView.setWebViewClient(new CustomWebViewClient());
        WebSettings webSetting = webView.getSettings();
        webSetting.setJavaScriptEnabled(true);
        //webSetting.setDisplayZoomControls(false);
        webView.loadUrl(postUrl);


    }


    private class CustomWebViewClient extends WebViewClient {
        @Override
        public void onPageStarted(WebView view, String url, Bitmap favicon) {
            // TODO Auto-generated method stub
            super.onPageStarted(view, url, favicon);
            finish();
        }

        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            // TODO Auto-generated method stub
            return false;

        }

        @Override
        public void onReceivedError(WebView view, int errorCode,
                                    String description, String failingUrl) {

        }

        @Override
        public void onPageFinished(WebView view, String url) {
            // TODO Auto-generated method stub
            finish();
            super.onPageFinished(view, url);

        }
    }

}
