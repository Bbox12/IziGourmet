package com.liteafrica.izigourmet.Model;

public class Canteens {
    
    private int ID;
    private double Latitude,Longitude,Distance;
    private String Name,Address;

    public int getNerarest(int p) {
        return nerarest;
    }

    public void setNerarest(int nerarest) {
        this.nerarest = nerarest;
    }

    private int nerarest;

    public int getID(int p) {
        return ID;
    }

    public void setID(int ID) {
        this.ID = ID;
    }

    public double getLatitude(int p) {
        return Latitude;
    }

    public void setLatitude(double latitude) {
        Latitude = latitude;
    }

    public double getLongitude(int p) {
        return Longitude;
    }

    public void setLongitude(double longitude) {
        Longitude = longitude;
    }

    public double getDistance(int p) {
        return Distance;
    }

    public void setDistance(double distance) {
        Distance = distance;
    }

    public String getName(int p) {
        return Name;
    }

    public void setName(String name) {
        Name = name;
    }

    public String getAddress(int p) {
        return Address;
    }

    public void setAddress(String address) {
        Address = address;
    }
}
