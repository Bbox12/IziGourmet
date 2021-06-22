package com.liteafrica.izigourmet.Model;

/**
 * Created by parag on 18/02/18.
 */

public class favs {

    public String from;
    private double Lat, Long;


    public double getLat(int position) {
        return Lat;
    }

    public void setLat(double lat) {
        Lat = lat;
    }

    public double getLong(int position) {
        return Long;
    }

    public void setLong(double aLong) {
        Long = aLong;
    }

    public String getFrom(int position) {
        return from;
    }

    public void setFrom(String from) {
        this.from = from;
    }

}
