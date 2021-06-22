package com.liteafrica.izigourmet.Adapters;

/**
 * Created by parag on 05/11/17.
 */

import android.content.Context;
import android.view.MotionEvent;
import android.widget.FrameLayout;

public class Drag_Map_Over_App extends FrameLayout {

    private OnDragListener mOnDragListener;

    public Drag_Map_Over_App(Context context) {
        super(context);
    }

    @Override
    public boolean dispatchTouchEvent(MotionEvent ev) {
        if (mOnDragListener != null) {
            mOnDragListener.onDrag(ev);
        }
        return super.dispatchTouchEvent(ev);
    }

    public void setOnDragListener(OnDragListener mOnDragListener) {
        this.mOnDragListener = mOnDragListener;
    }

    public interface OnDragListener {
        void onDrag(MotionEvent motionEvent);
    }
}
