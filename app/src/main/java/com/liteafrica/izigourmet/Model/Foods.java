package com.liteafrica.izigourmet.Model;

import java.util.ArrayList;

public class Foods {

    public static final String TABLE_NAME = "foods";
    public static final String COLUMN_ID = "ID";
    public static final String VEG = "veg";
    public static final String NAME = "name";
    public static final String CANTEEN = "CANTEEN";
    public static final String PHOTO = "PHOTO";
    public static final String MENU_TYPE = "MENU_TYPE";
    public static final String MENU_NAME = "MANU_NAME";
    public static final String EPERCENTAGE = "EP";
    public static final String EPRICE = "EPRICE";
    public static final String PRICE = "PRICE";
    public static final String DISCOUNT = "DISCOUNT";
    public static final String URL = "CURL";
    public static final String CLOSINGTIME = "CT";
    public static final String OPENTIME = "OT";
    public static final String MINIMUMORDERS = "MO";
    public static final String NONVEG = "NONVEG";
    public static final String MINIMUMTIME = "MT";
    public static final String MINIMUMPERSON = "MP";
    public static final String RATING = "RATING";
    public static final String NOOFPERSON = "NP";
    public static final String IMAGE = "IMAGE";
    public static final String ADDRESS = "ADDRESS";
    public static final String CREATE_TABLE =
            "CREATE TABLE " + TABLE_NAME + "("
                    + COLUMN_ID + " INTEGER PRIMARY KEY AUTOINCREMENT,"
                    + VEG + " TEXT,"
                    + NAME + " TEXT,"
                    + CANTEEN + " TEXT,"
                    + PHOTO + " TEXT,"
                    + MENU_TYPE + " TEXT,"
                    + MENU_NAME + " TEXT,"
                    + EPERCENTAGE + " TEXT,"
                    + EPRICE + " TEXT,"
                    + PRICE + " TEXT,"
                    + DISCOUNT + " TEXT,"
                    + URL + " TEXT,"
                    + CLOSINGTIME + " TEXT,"
                    + OPENTIME + " TEXT,"
                    + MINIMUMORDERS + " TEXT,"
                    + NONVEG + " TEXT,"
                    + MINIMUMTIME + " TEXT,"
                    + MINIMUMPERSON + " TEXT,"
                    + RATING + " TEXT,"
                    + NOOFPERSON + " TEXT,"
                    + IMAGE + " TEXT,"
                    + ADDRESS + " TEXT"

                    + ")";
    private static final long serialVersionUID = 1L;
    private String Name;
    private String Menu, Submenu, Subsubmenu;
    private String Menu_Name;
    private String Photo;
    private String Reviews;
    private String Open_time;
    private String Closing_time;
    private String Minimum_orders;
    private String CURL, Address, Details;
    private double dis, Dcharge, Rating;
    private ArrayList<_menu> rvMenu;
    private String Image, Canteen;
    private double Price, eTEZ_Perchantage, eTEZ_Price, Discount, FRating;
    private int ID, isDelivery;
    private int Veg;
    private int NoofItems;
    private int Minimum_person;
    private int Minimum_time;
    private int NonVeg, NoofPersons1;
    private int NoofPerson;

    public ArrayList<_menu> getRvMenu(int position) {
        return rvMenu;
    }

    public void setRvMenu(ArrayList<_menu> rvMenu) {
        this.rvMenu = rvMenu;
    }

    public String getMenu(int position) {
        return Menu;
    }

    public void setMenu(String menu) {
        Menu = menu;
    }

    public String getSubmenu(int position) {
        return Submenu;
    }

    public void setSubmenu(String submenu) {
        Submenu = submenu;
    }

    public String getSubsubmenu(int position) {
        return Subsubmenu;
    }

    public void setSubsubmenu(String subsubmenu) {
        Subsubmenu = subsubmenu;
    }

    public double getDis(int position) {
        return dis;
    }

    public void setDis(double dis) {
        this.dis = dis;
    }

    public String getAddress(int position) {
        return Address;
    }

    public void setAddress(String address) {
        Address = address;
    }

    public double getFRating(int position) {
        return FRating;
    }

    public void setFRating(double rating) {
        FRating = rating;
    }

    public int getNoofPersons1(int position) {
        return NoofPersons1;
    }

    public void setNoofPersons1(int noofPersons) {
        NoofPersons1 = noofPersons;
    }

    public double getDcharge(int position) {
        return Dcharge;
    }

    public void setDcharge(double dcharge) {
        Dcharge = dcharge;
    }

    public int getIsDelivery(int position) {
        return isDelivery;
    }

    public void setIsDelivery(int isDelivery) {
        this.isDelivery = isDelivery;
    }

    public String getDetails(int position) {
        return Details;
    }

    public void setDetails(String details) {
        Details = details;
    }

    public String getImage(int position) {
        return Image;
    }

    public void setImage(String image) {
        Image = image;
    }

    public String getCanteen(int position) {
        return Canteen;
    }

    public void setCanteen(String canteen) {
        Canteen = canteen;
    }

    public int getNoofPerson(int position) {
        return NoofPerson;
    }

    public void setNoofPerson(int noofPerson) {
        NoofPerson = noofPerson;
    }

    public int getNonVeg(int position) {
        return NonVeg;
    }

    public void setNonVeg(int nonVeg) {
        NonVeg = nonVeg;
    }

    public String getName(int position) {
        return Name;
    }

    public void setName(String name) {
        Name = name;
    }


    public String getMenu_Name(int position) {
        return Menu_Name;
    }

    public void setMenu_Name(String menu_Name) {
        Menu_Name = menu_Name;
    }

    public String getPhoto(int position) {
        return Photo;
    }

    public void setPhoto(String photo) {
        Photo = photo;
    }

    public String getReviews(int position) {
        return Reviews;
    }

    public void setReviews(String reviews) {
        Reviews = reviews;
    }

    public String getOpen_time(int position) {
        return Open_time;
    }

    public void setOpen_time(String open_time) {
        Open_time = open_time;
    }

    public String getClosing_time(int position) {
        return Closing_time;
    }

    public void setClosing_time(String closing_time) {
        Closing_time = closing_time;
    }

    public String getMinimum_orders(int position) {
        return Minimum_orders;
    }

    public void setMinimum_orders(String minimum_orders) {
        Minimum_orders = minimum_orders;
    }

    public String getCURL(int position) {
        return CURL;
    }

    public void setCURL(String CURL) {
        this.CURL = CURL;
    }

    public double getPrice(int position) {
        return Price;
    }

    public void setPrice(double price) {
        Price = price;
    }

    public double geteTEZ_Perchantage(int position) {
        return eTEZ_Perchantage;
    }

    public void seteTEZ_Perchantage(double eTEZ_Perchantage) {
        this.eTEZ_Perchantage = eTEZ_Perchantage;
    }

    public double geteTEZ_Price(int position) {
        return eTEZ_Price;
    }

    public void seteTEZ_Price(double eTEZ_Price) {
        this.eTEZ_Price = eTEZ_Price;
    }

    public double getDiscount(int position) {
        return Discount;
    }

    public void setDiscount(double discount) {
        Discount = discount;
    }

    public double getRating(int position) {
        return Rating;
    }

    public void setRating(double rating) {
        Rating = rating;
    }

    public int getID(int position) {
        return ID;
    }

    public void setID(int ID) {
        this.ID = ID;
    }

    public int getVeg(int position) {
        return Veg;
    }

    public void setVeg(int veg) {
        Veg = veg;
    }

    public int getNoofItems(int position) {
        return NoofItems;
    }

    public void setNoofItems(int noofItems) {
        NoofItems = noofItems;
    }

    public int getMinimum_person(int position) {
        return Minimum_person;
    }

    public void setMinimum_person(int minimum_person) {
        Minimum_person = minimum_person;
    }

    public int getMinimum_time(int position) {
        return Minimum_time;
    }

    public void setMinimum_time(int minimum_time) {
        Minimum_time = minimum_time;
    }
}
