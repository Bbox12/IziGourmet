package com.liteafrica.izigourmet.Activites;

/**
 * Created by parag on 05/11/17.
 */

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.google.android.gms.maps.MapFragment;
import com.liteafrica.izigourmet.Adapters.Drag_Map_Over_App;

public class CustomMapFragment extends MapFragment {

    private View mOriginalView;
    private Drag_Map_Over_App mMapWrapperLayout;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        mOriginalView = super.onCreateView(inflater, container, savedInstanceState);

        mMapWrapperLayout = new Drag_Map_Over_App(getActivity());
        mMapWrapperLayout.addView(mOriginalView);

        return mMapWrapperLayout;
    }

    @Override
    public View getView() {
        return mOriginalView;
    }

    public void setOnDragListener(Drag_Map_Over_App.OnDragListener onDragListener, boolean pick) {
        if (pick) {
            mMapWrapperLayout.setOnDragListener(onDragListener);
        }
    }
}
