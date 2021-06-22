package com.liteafrica.izigourmet.Model;

import java.util.ArrayList;

/**
 * Created by parag on 04/11/17.
 */

public class User {

    public String from;

    public String getArea(int p) {
        return area;
    }

    public void setArea(String area) {
        this.area = area;
    }

    public String getShopName(int p) {
        return ShopName;
    }

    public void setShopName(String shopName) {
        ShopName = shopName;
    }

    public String getShopAddress(int p) {
        return ShopAddress;
    }

    public void setShopAddress(String shopAddress) {
        ShopAddress = shopAddress;
    }

    public String ShopName;
    public String ShopAddress;
    public String area;
    public String to;
    public String date;
    public String time;
    public String Snapshot;
    private String DriverImage;
    private String Unique_id, Address;
    private String Vehicle;
    private String Drivername;
    private String DriverRate;
    private String Cost, pCost;
    private String Start_time;
    private String End_time, End_date, OrderID;
    private String Review;
    private ArrayList<Foods> rvMenu;
    private int Delivered;
    private int pMode;
    private int PaymentVerified;
    private int PaymentMode;
    private int Is_Paid;

    public int getType(int p) {
        return Type;
    }

    public void setType(int type) {
        Type = type;
    }

    private int Type;

    public int getIs_Paid(int position) {
        return Is_Paid;
    }

    public void setIs_Paid(int is_Paid) {
        Is_Paid = is_Paid;
    }

    public int getPaymentMode(int position) {
        return PaymentMode;
    }

    public void setPaymentMode(int paymentMode) {
        PaymentMode = paymentMode;
    }

    public int getPaymentVerified(int position) {
        return PaymentVerified;
    }

    public void setPaymentVerified(int paymentVerified) {
        PaymentVerified = paymentVerified;
    }

    public int getpMode(int position) {
        return pMode;
    }

    public void setpMode(int pMode) {
        this.pMode = pMode;
    }

    public String getpCost(int position) {
        return pCost;
    }

    public void setpCost(String pCost) {
        this.pCost = pCost;
    }

    public ArrayList<Foods> getRvMenu(int position) {
        return rvMenu;
    }

    public void setRvMenu(ArrayList<Foods> rvMenu) {
        this.rvMenu = rvMenu;
    }

    public String getEnd_date(int position) {
        return End_date;
    }

    public void setEnd_date(String end_date) {
        End_date = end_date;
    }

    public String getOrderID(int position) {
        return OrderID;
    }

    public void setOrderID(String orderID) {
        OrderID = orderID;
    }

    public String getReview(int position) {
        return Review;
    }

    public void setReview(String review) {
        Review = review;
    }

    public String getStart_time(int position) {
        return Start_time;
    }

    public void setStart_time(String start_time) {
        Start_time = start_time;
    }

    public String getEnd_time(int position) {
        return End_time;
    }

    public void setEnd_time(String end_time) {
        End_time = end_time;
    }

    public String getCost(int position) {
        return Cost;
    }

    public void setCost(String cost) {
        Cost = cost;
    }

    public String getDriverRate(int position) {
        return DriverRate;
    }

    public void setDriverRate(String driverRate) {
        DriverRate = driverRate;
    }

    public String getDrivername(int position) {
        return Drivername;
    }

    public void setDrivername(String drivername) {
        Drivername = drivername;
    }

    public String getVehicle(int position) {
        return Vehicle;
    }

    public void setVehicle(String vehicle) {
        Vehicle = vehicle;
    }

    public String getUnique_id(int position) {
        return Unique_id;
    }

    public void setUnique_id(String unique_id) {
        Unique_id = unique_id;
    }

    public String getDriverImage(int position) {
        return DriverImage;
    }

    public void setDriverImage(String driverImage) {
        DriverImage = driverImage;
    }

    public String getSnapshot(int position) {
        return Snapshot;
    }

    public void setSnapshot(String snapshot) {
        Snapshot = snapshot;
    }

    public String getFrom(int position) {
        return from;
    }

    public void setFrom(String from) {
        this.from = from;
    }

    public String getTo(int position) {
        return to;
    }

    public void setTo(String to) {
        this.to = to;
    }

    public String getDate(int position) {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getTime(int position) {
        return time;
    }

    public void setTime(String time) {
        this.time = time;
    }

    public int getDelivered(int position) {
        return Delivered;
    }

    public void setDelivered(int delivered) {
        Delivered = delivered;
    }

    public String getAddress(int position) {
        return Address;
    }

    public void setAddress(String address) {
        Address = address;
    }


}