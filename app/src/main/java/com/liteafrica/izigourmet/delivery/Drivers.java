package com.liteafrica.izigourmet.delivery;

/**
 * Created by parag on 04/11/17.
 */

public class Drivers {

    public String OTP, Vehicle, Unique_ride, User_from, User_to, User_mobile, Minimum_fare, Hourly_fare;
    public String User_from_lat, User_from_long, User_to_lat, User_to_long, Cost, Seat;

    public String getSeat(int position) {
        return Seat;
    }

    public void setSeat(String seat) {
        Seat = seat;
    }

    public String getUser_from_lat(int position) {
        return User_from_lat;
    }

    public void setUser_from_lat(String user_from_lat) {
        User_from_lat = user_from_lat;
    }

    public String getUser_from_long(int position) {
        return User_from_long;
    }

    public void setUser_from_long(String user_from_long) {
        User_from_long = user_from_long;
    }

    public String getUser_to_lat(int position) {
        return User_to_lat;
    }

    public void setUser_to_lat(String user_to_lat) {
        User_to_lat = user_to_lat;
    }

    public String getUser_to_long(int position) {
        return User_to_long;
    }

    public void setUser_to_long(String user_to_long) {
        User_to_long = user_to_long;
    }

    public String getVehicle(int position) {
        return Vehicle;
    }

    public void setVehicle(String vehicle) {
        Vehicle = vehicle;
    }

    public String getOTP(int position) {
        return OTP;
    }

    public void setOTP(String OTP) {
        this.OTP = OTP;
    }

    public String getUnique_ride(int position) {
        return Unique_ride;
    }

    public void setUnique_ride(String unique_ride) {
        Unique_ride = unique_ride;
    }

    public String getUser_from(int position) {
        return User_from;
    }

    public void setUser_from(String user_from) {
        User_from = user_from;
    }

    public String getUser_to(int position) {
        return User_to;
    }

    public void setUser_to(String user_to) {
        User_to = user_to;
    }

    public String getUser_mobile(int position) {
        return User_mobile;
    }

    public void setUser_mobile(String user_mobile) {
        User_mobile = user_mobile;
    }
}