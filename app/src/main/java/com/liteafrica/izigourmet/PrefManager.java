package com.liteafrica.izigourmet;

import android.content.Context;
import android.content.SharedPreferences;

import com.google.gson.Gson;
import com.liteafrica.izigourmet.Model.Foods;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Set;

/**
 * Created by parag on 12/01/17.
 */
public class PrefManager {
    public static final String KEY_MOBILE = "mobile";
    public static final String KEY_NAME = "names";
    public static final String cEMAIL = "cemaol";
    private static final String NEW_VERSION = "Newversion";
    // Shared preferences file name
    private static final String PREF_NAME = "Contri";
    // All Shared Preferences Keys
    private static final String KEY_IS_WAITING_FOR_SMS = "IsWaitingForSms";
    private static final String KEY_IS_LOGGED_IN = "isLoggedIn";
    private static final String NEW_UNIQUE_RIDE = "Ride";
    private static final String NEW_PROFILE = "profile";
    private static final String NEW_REVIEW = "review";
    private static final String NEW_NAME = "name";
    private static final String CANCEL_1 = "c1";
    private static final String CANCEL_2 = "c2";
    private static final String CANCEL_3 = "c3";
    private static final String CANCEL_4 = "c4";
    private static final String CANCEL_5 = "c5";
    private static final String REGID = "regId";
    private static final String KEY_IS_SHARE = "isshare";
    private static final String KEY_DROP_AT = "DROP";
    private static final String KEY_PICK_UP = "PICK";
    private static final String KEY_DROP_LAT = "dlat";
    private static final String KEY_DROP_LONG = "dlong";
    private static final String KEY_PICK_LAT = "plat";
    private static final String KEY_PICK_LONG = "plong";
    private static final String DRIVER_PHN = "dphn";
    private static final String Ride_ID = "dcided";
    private static final String DPHONE = "dphn";
    private static final String NEW_IMP = "imp";
    private static final String PREF1 = "pref1";
    private static final String PREF2 = "pref2";
    private static final String PREF3 = "pref3";
    private static final String PREF4 = "pref4";
    private static final String iPREF1 = "ipref1";
    private static final String iPREF2 = "ipref2";
    private static final String iPREF3 = "ipref3";
    private static final String iPREF4 = "ipref4";
    private static final String COUNT = "count";
    private static final String FOODITEMS = "Fooditems";
    private static final String FOODMONEY = "FoodMoney";
    private static final String FOOD_LIST = "foodlist";
    private static final String CANTEENS_LIST = "canteenlist";
    private static final String CID = "cid";
    private static final String CID1 = "cid1";
    private static final String CANTEEN = "canteen";
    private static final String DELE = "setDelivery";
    private static final String SETRIDE = "setRide";
    private static final String CHARGE = "charge";
    private static final String RIDE = "ride";
    private static final String CANTEENS_FILTERS = "filters";
    private static final String CLOSE = "close";
    private static final String MO = "mo";
    private static final String TOTAL = "total";
    private static final String DISTANCE = "minimumdistance";
    private static final String OTP = "otp";
    private static final String NEW_ORDER = "NEW_ORDER";
    private static final String NEW_GOTRIDE = "NEW_GOTRIDE";
    private static final String KEY_OFFLINE = "KEY_OFFLINE";
    private static final String COST = "ccsor";
    private static final String _VEHICLE = "_VEHICLE";
    private static final String NEW_STAR = "NEW_STAR";
    private static final String SAVEDADDRESS = "savedaddress";
    private static final String RESPOSIBILITY = "RESPOSIBILITY";
    private static final String PAYMENT = "payment";
    private static final String DRIVERIMAGE = "DRIVERIMAGE";
    private static final String DRIVERNAME = "DRIVERNMAE";
    private static final String FROM1 = "FROM1";
    private static final String FROM2 = "FROM2";
    private static final String ADTEXT = "adtext";
    private static final String WHATSAPP = "whatsapp";
    private static final String YOUTUBES = "youtubev";
    private static final String FACEBOOK = "facebook";
    private static final String INSTAGRAM = "instagram";
    private static final String TOTA2L = "TOTA2L";
    private static final String _no_of_seats = "nos";
    private static final String ID1 = "ID1";
    private static final String ID2 = "ID2";
    private static final String ID3 = "ID3";
    private static final String ID4 = "ID4";
    private static final String ID5 = "ID5";
    private static final String noOfItems = "noOfItems";
    private static final String iRate1 = "r1";
    private static final String iRate2 = "r2";
    private static final String iRate3 = "r3";
    private static final String iRate4 = "r4";
    private static final String cNAme = "cname";
    private static final String cAddress = "caddress";
    private static final String cPhoto = "cphoto";
    private static final String cDiscount = "cd";
    private static final String cPackaging = "cp";
    private static final String cLess = "cless";
    private static final String cMore = "cmore";
    private static final String KEY_DROP_AT1 = "DROP1";
    private static final String KEY_PICK_UP1 = "PICK1";
    private static final String KEY_DROP_LAT1 = "dlat1";
    private static final String KEY_DROP_LONG1 = "dlong1";
    private static final String KEY_PICK_LAT1 = "plat1";
    private static final String KEY_PICK_LONG1 = "plong1";
    private static final String HOME = "home";
    private static final String WORK = "work";
    private static final String OTHER = "other";
    private static final String KEY_H_LAT = "hlat";
    private static final String KEY_H_LONG = "hlong";
    private static final String KEY_W_LAT = "wlat";
    private static final String KEY_W_LONG = "wlong";
    private static final String KEY_O_LAT = "olat";
    private static final String KEY_O_LONG = "olong";
    private static final String KEY_SELECTED = "oselected";
    private static final String KEY_DATE = "date";
    private static final String KEY_CLOSE1 = "close1";
    private static final String KEY_OPEN1 = "open1";
    private static final String KEY_CLOSE2 = "close2";
    private static final String KEY_OPEN2 = "open2";
    private static final String KEY_CLOSE3 = "close3";
    private static final String KEY_OPEN3 = "open3";
    private static final String KEY_CLOSE4 = "close4";
    private static final String KEY_OPEN4 = "open4";
    private static final String KEY_ISD = "isd";
    private static final String KEY_D_CHARGE = "dc";
    SharedPreferences pref;
    SharedPreferences.Editor editor;
    Context _context;
    int PRIVATE_MODE = 0;
    private ArrayList<String> arrPackage = new ArrayList<>();

    public PrefManager(Context context) {
        this._context = context;
        pref = _context.getSharedPreferences(PREF_NAME, PRIVATE_MODE);
        editor = pref.edit();
    }


    public int getResposibility() {
        return pref.getInt(RESPOSIBILITY, 0);
    }

    public void setResponsibility(int imp) {
        editor.putInt(RESPOSIBILITY, imp);
        editor.commit();
    }


    public int getisDel() {
        return pref.getInt(KEY_ISD, 0);
    }


    public void setisDel(int cost) {
        editor.putInt(KEY_ISD, cost);
        editor.commit();
    }

    public float getDcharge() {
        return pref.getFloat(KEY_D_CHARGE, 0);
    }

    public void setDcharge(float cost) {
        editor.putFloat(KEY_D_CHARGE, cost);
        editor.commit();
    }

    public String getEmail() {
        return pref.getString(cEMAIL, null);
    }

    public void setEmail(String imp) {
        editor.putString(cEMAIL, imp);
        editor.commit();
    }

    public String getOther() {
        return pref.getString(OTHER, null);
    }


    public void setOther(String cost) {
        editor.putString(OTHER, cost);
        editor.commit();
    }

    public String getClostingTime1() {
        return pref.getString(KEY_CLOSE1, null);
    }


    public void setClostingTime1(String cost) {
        editor.putString(KEY_CLOSE1, cost);
        editor.commit();
    }

    public String getOpeningTime1() {
        return pref.getString(KEY_OPEN1, null);
    }


    public void setOpeningTime1(String cost) {
        editor.putString(KEY_OPEN1, cost);
        editor.commit();
    }

    public String getWork() {
        return pref.getString(WORK, null);
    }


    public void setWork(String cost) {
        editor.putString(WORK, cost);
        editor.commit();
    }

    public String getHome() {
        return pref.getString(HOME, null);
    }


    public void setHome(String cost) {
        editor.putString(HOME, cost);
        editor.commit();
    }

    public String getKeyHLat() {
        return pref.getString(KEY_H_LAT, null);
    }

    public void setKeyHLat(String rate) {
        editor.putString(KEY_H_LAT, rate);
        editor.commit();

    }

    public String getKeyWLat() {
        return pref.getString(KEY_W_LAT, null);
    }

    public void setKeyWLat(String rate) {
        editor.putString(KEY_W_LAT, rate);
        editor.commit();

    }

    public String getKeyOLat() {
        return pref.getString(KEY_O_LAT, null);
    }

    public void setKeyOLat(String rate) {
        editor.putString(KEY_O_LAT, rate);
        editor.commit();

    }


    public String getKeyHLong() {
        return pref.getString(KEY_H_LONG, null);
    }

    public void setKeyHLong(String rate) {
        editor.putString(KEY_H_LONG, rate);
        editor.commit();

    }

    public String getKeyWLong() {
        return pref.getString(KEY_W_LONG, null);
    }

    public void setKeyWLong(String rate) {
        editor.putString(KEY_W_LONG, rate);
        editor.commit();

    }

    public String getKeyOLong() {
        return pref.getString(KEY_O_LONG, null);
    }

    public void setKeyOLong(String rate) {
        editor.putString(KEY_O_LONG, rate);
        editor.commit();

    }

    public String getcName() {
        return pref.getString(cNAme, null);
    }

    public void setcName(String imp) {
        editor.putString(cNAme, imp);
        editor.commit();
    }

    public String getcAddress() {
        return pref.getString(cAddress, null);
    }

    public void setcAddress(String imp) {
        editor.putString(cAddress, imp);
        editor.commit();
    }

    public String getcPhoto() {
        return pref.getString(cPhoto, null);
    }

    public void setcPhoto(String imp) {
        editor.putString(cPhoto, imp);
        editor.commit();
    }

    public float getcDiscount() {
        return pref.getFloat(cDiscount, 0);
    }

    public void setcDiscount(float imp) {
        editor.putFloat(cDiscount, imp);
        editor.commit();
    }

    public int getcPackaging() {
        return pref.getInt(cPackaging, 0);
    }

    public void setcPackaging(int imp) {
        editor.putInt(cPackaging, imp);
        editor.commit();
    }

    public String getcLess() {
        return pref.getString(cLess, null);
    }

    public void setcLess(String imp) {
        editor.putString(cLess, imp);
        editor.commit();
    }

    public String getcMore() {
        return pref.getString(cMore, null);
    }

    public void setcMore(String imp) {
        editor.putString(cMore, imp);
        editor.commit();
    }

    public int getMinimumOrder() {
        return pref.getInt(MO, 0);
    }

    public void setMinimumOrder(int imp) {
        editor.putInt(MO, imp);
        editor.commit();
    }

    public int getRide() {
        return pref.getInt(SETRIDE, 0);
    }

    public void setRide(int imp) {
        editor.putInt(SETRIDE, imp);
        editor.commit();
    }

    public int get_ride() {
        return pref.getInt(RIDE, 0);
    }

    public void set_ride(int imp) {
        editor.putInt(RIDE, imp);
        editor.commit();
    }

    public int get_cID1() {
        return pref.getInt(CID1, 0);
    }

    public void set_cID1(int imp) {
        editor.putInt(CID1, imp);
        editor.commit();
    }

    public int get_cID() {
        return pref.getInt(CID, 0);
    }

    public void set_cID(int imp) {
        editor.putInt(CID, imp);
        editor.commit();
    }

    public int getDelivery() {
        return pref.getInt(DELE, 0);
    }

    public void setDelivery(int imp) {
        editor.putInt(DELE, imp);
        editor.commit();
    }

    public int get_food_items() {
        return pref.getInt(FOODITEMS, 0);
    }

    public void set_food_items(int imp) {
        editor.putInt(FOODITEMS, imp);
        editor.commit();
    }

    public String getCanteen() {
        return pref.getString(CANTEEN, null);
    }

    public void setCanteen(String regId) {
        editor.putString(CANTEEN, regId);
        editor.commit();
    }

    public Set<String> getFilters() {
        return pref.getStringSet(CANTEENS_FILTERS, null);
    }

    public void setFilters(ArrayList<String> foods) {
        Set<String> set = new HashSet<String>();
        if (foods != null) {
            set.addAll(foods);
        } else {
            set.clear();

        }
        editor.putStringSet(CANTEENS_FILTERS, set);
        editor.apply();

    }

    public String getCanteens() {
        return pref.getString(CANTEENS_LIST, null);

    }

    public void setCanteens(ArrayList<Foods> foods) {
        Gson gson = new Gson();
        String json = gson.toJson(foods);
        editor.putString(CANTEENS_LIST, json);
        editor.apply();

    }

    public void setadTetxt(ArrayList<String> foods) {
        Set<String> set = new HashSet<String>();
        if (foods != null) {
            set.addAll(foods);
        } else {
            set.clear();

        }
        editor.putStringSet(ADTEXT, set);
        editor.apply();

    }

    public Set<String> getadTetxt() {
        return pref.getStringSet(ADTEXT, null);
    }

    public void packagesharedPreferences(ArrayList<String> foods) {
        Set<String> set = new HashSet<String>();
        if (foods != null) {
            set.addAll(foods);
        } else {
            set.clear();

        }
        editor.putStringSet(FOOD_LIST, set);
        editor.apply();

    }

    public Set<String> get_packagesharedPreferences() {
        return pref.getStringSet(FOOD_LIST, null);
    }

    public void setnoOfItems(ArrayList<String> foods) {
        Set<String> set = new HashSet<String>();
        if (foods != null) {
            set.addAll(foods);
        } else {
            set.clear();

        }
        editor.putStringSet(noOfItems, set);
        editor.apply();

    }

    public Set<String> getnoOfItems() {
        return pref.getStringSet(noOfItems, null);
    }


    public float get_food_money() {
        return pref.getFloat(FOODMONEY, 0);
    }

    public void set_food_money(float imp) {
        editor.putFloat(FOODMONEY, imp);
        editor.commit();
    }

    public int get_no_of_seats() {
        return pref.getInt(_no_of_seats, 0);
    }

    public void set_no_of_seats(int imp) {
        editor.putInt(_no_of_seats, imp);
        editor.commit();
    }

    public int getCount() {
        return pref.getInt(COUNT, 0);
    }

    public void setCount(int imp) {
        editor.putInt(COUNT, imp);
        editor.commit();
    }

    public String getDriverName() {
        return pref.getString(DRIVERNAME, null);
    }

    public void setDriverName(String cost) {
        editor.putString(DRIVERNAME, cost);
        editor.commit();
    }

    public String getDriverimage() {
        return pref.getString(DRIVERIMAGE, null);
    }

    public void setDriverimage(String cost) {
        editor.putString(DRIVERIMAGE, cost);
        editor.commit();
    }

    public String getDriverPhone() {
        return pref.getString(DPHONE, null);
    }

    public void setDriverPhone(String regId) {
        editor.putString(DPHONE, regId);
        editor.commit();
    }

    public String getCon() {
        return pref.getString(Ride_ID, null);
    }

    public void setCon(String dc) {
        editor.putString(Ride_ID, dc);
        editor.commit();
    }

    public float getReview() {
        return pref.getFloat(NEW_REVIEW, 0);
    }

    public void setReview(float review) {
        editor.putFloat(NEW_REVIEW, review);
        editor.commit();
    }

    public String getRegID() {
        return pref.getString(REGID, null);
    }

    public void setRegID(String regId) {
        editor.putString(REGID, regId);
        editor.commit();
    }

    public String getCancel1() {
        return pref.getString(CANCEL_1, null);
    }

    public void setCancel1(String image) {
        editor.putString(CANCEL_1, image);
        editor.commit();
    }

    public String getCancel2() {
        return pref.getString(CANCEL_2, null);
    }

    public void setCancel2(String image) {
        editor.putString(CANCEL_2, image);
        editor.commit();
    }

    public String getCancel3() {
        return pref.getString(CANCEL_3, null);
    }

    public void setCancel3(String image) {
        editor.putString(CANCEL_3, image);
        editor.commit();
    }

    public String getCancel4() {
        return pref.getString(CANCEL_4, null);
    }

    public void setCancel4(String image) {
        editor.putString(CANCEL_4, image);
        editor.commit();
    }

    public String getCancel5() {
        return pref.getString(CANCEL_5, null);
    }

    public void setCancel5(String image) {
        editor.putString(CANCEL_5, image);
        editor.commit();
    }

    public String getName() {
        return pref.getString(NEW_NAME, null);
    }

    public void setName(String profile) {
        editor.putString(NEW_NAME, profile);
        editor.commit();
    }

    public String getUniqueRide() {
        return pref.getString(NEW_UNIQUE_RIDE, null);
    }

    public void setUniqueRide(String ride) {
        editor.putString(NEW_UNIQUE_RIDE, ride);
        editor.commit();
    }

    public String getProfile() {
        return pref.getString(NEW_PROFILE, null);
    }

    public void setProfile(String profile) {
        editor.putString(NEW_PROFILE, profile);
        editor.commit();
    }

    public void setIsWaitingForSms(boolean isWaiting) {
        editor.putBoolean(KEY_IS_WAITING_FOR_SMS, isWaiting);
        editor.commit();
    }


    public void createLogin(String mobile, String name) {
        editor.putString(KEY_MOBILE, mobile);
        editor.putString(KEY_NAME, name);
        editor.putBoolean(KEY_IS_LOGGED_IN, true);
        editor.commit();
    }

    public boolean isLoggedIn() {
        return pref.getBoolean(KEY_IS_LOGGED_IN, false);
    }

    public void clearSession() {
        editor.clear();
        editor.commit();
    }


    public HashMap<String, String> getUserDetails() {
        HashMap<String, String> profile = new HashMap<>();
        profile.put(KEY_MOBILE, pref.getString(KEY_MOBILE, null));
        profile.put(KEY_NAME, pref.getString(KEY_NAME, null));
        return profile;
    }

    public int getNewVersion() {
        return pref.getInt(NEW_VERSION, 0);
    }

    public void setNewVersion(int version) {
        editor.putInt(NEW_VERSION, version);
        editor.commit();
    }

    public int getImp() {
        return pref.getInt(NEW_IMP, 0);
    }

    public void setImp(int imp) {
        editor.putInt(NEW_IMP, imp);
        editor.commit();
    }

    public void deleteState() {
        editor.clear().commit();
    }


    public int getisShare() {
        return pref.getInt(KEY_IS_SHARE, 0);
    }

    public void setisShare(int _share) {
        editor.putInt(KEY_IS_SHARE, _share);
        editor.commit();
    }

    public String getDropLat() {
        return pref.getString(KEY_DROP_LAT, null);
    }

    public void setDropLat(String rate) {
        editor.putString(KEY_DROP_LAT, rate);
        editor.commit();

    }

    public String getDropLong() {
        return pref.getString(KEY_DROP_LONG, null);
    }

    public void setDropLong(String rate) {
        editor.putString(KEY_DROP_LONG, rate);
        editor.commit();
    }

    public String getDropAt() {
        return pref.getString(KEY_DROP_AT, null);
    }

    public void setDropAt(String drop) {
        editor.putString(KEY_DROP_AT, drop);
        editor.commit();
    }

    public String getPickAt() {
        return pref.getString(KEY_PICK_UP, null);
    }

    public void setPickAt(String drop) {
        editor.putString(KEY_PICK_UP, drop);
        editor.commit();
    }

    public String getPickLat() {
        return pref.getString(KEY_PICK_LAT, null);
    }

    public void setPickLat(String rate) {
        editor.putString(KEY_PICK_LAT, rate);
        editor.commit();

    }

    public String getPickLong() {
        return pref.getString(KEY_PICK_LONG, null);
    }

    public void setPickLong(String rate) {
        editor.putString(KEY_PICK_LONG, rate);
        editor.commit();
    }

    public int getPref1() {
        return pref.getInt(PREF1, 0);
    }

    public void setPref1(int regId) {
        editor.putInt(PREF1, regId);
        editor.commit();
    }

    public int getPref2() {
        return pref.getInt(PREF2, 0);
    }

    public void setPref2(int regId) {
        editor.putInt(PREF2, regId);
        editor.commit();
    }

    public String getPref3() {
        return pref.getString(PREF3, null);
    }

    public void setPref3(String regId) {
        editor.putString(PREF3, regId);
        editor.commit();
    }

    public String getPref4() {
        return pref.getString(PREF4, null);
    }

    public void setPref4(String regId) {
        editor.putString(PREF4, regId);
        editor.commit();
    }

    public String getiPref1() {
        return pref.getString(iPREF1, null);
    }

    public void setiPref1(String regId) {
        editor.putString(iPREF1, regId);
        editor.commit();
    }

    public String getiPref2() {
        return pref.getString(iPREF2, null);
    }

    public void setiPref2(String regId) {
        editor.putString(iPREF2, regId);
        editor.commit();
    }

    public String getiPref3() {
        return pref.getString(iPREF3, null);
    }

    public void setiPref3(String regId) {
        editor.putString(iPREF3, regId);
        editor.commit();
    }

    public String getiPref4() {
        return pref.getString(iPREF4, null);
    }

    public void setiPref4(String regId) {
        editor.putString(iPREF4, regId);
        editor.commit();
    }

    public float getiRate1() {
        return pref.getFloat(iRate1, 0);
    }

    public void setiRate1(float regId) {
        editor.putFloat(iRate1, regId);
        editor.commit();
    }

    public float getiRate2() {
        return pref.getFloat(iRate2, 0);
    }

    public void setiRate2(float regId) {
        editor.putFloat(iRate2, regId);
        editor.commit();
    }

    public float getiRate3() {
        return pref.getFloat(iRate3, 0);
    }

    public void setiRate3(float regId) {
        editor.putFloat(iRate3, regId);
        editor.commit();
    }

    public float getiRate4() {
        return pref.getFloat(iRate4, 0);
    }

    public void setiRate4(float regId) {
        editor.putFloat(iRate4, regId);
        editor.commit();
    }

    public int getID1() {
        return pref.getInt(ID1, 0);
    }

    public void setID1(int regId) {
        editor.putInt(ID1, regId);
        editor.commit();
    }

    public int getID2() {
        return pref.getInt(ID2, 0);
    }

    public void setID2(int regId) {
        editor.putInt(ID2, regId);
        editor.commit();
    }

    public int getFrom1() {
        return pref.getInt(FROM1, 0);
    }

    public void setFrom1(int regId) {
        editor.putInt(FROM1, regId);
        editor.commit();
    }

    public int getFrom2() {
        return pref.getInt(FROM2, 0);
    }

    public void setFrom2(int regId) {
        editor.putInt(FROM2, regId);
        editor.commit();
    }

    public int getID3() {
        return pref.getInt(ID3, 0);
    }

    public void setID3(int regId) {
        editor.putInt(ID3, regId);
        editor.commit();
    }

    public int getID4() {
        return pref.getInt(ID4, 0);
    }

    public void setID4(int regId) {
        editor.putInt(ID4, regId);
        editor.commit();
    }

    public int getID5() {
        return pref.getInt(ID5, 0);
    }

    public void setID5(int regId) {
        editor.putInt(ID5, regId);
        editor.commit();
    }


    public int getClose() {
        return pref.getInt(CLOSE, 0);
    }

    public void setClose(int regId) {
        editor.putInt(CLOSE, regId);
        editor.commit();
    }

    public int getCharge() {
        return pref.getInt(CHARGE, 0);
    }

    public void setCharge(int regId) {
        editor.putInt(CHARGE, regId);
        editor.commit();
    }

    public String getDropLat1() {
        return pref.getString(KEY_DROP_LAT1, null);
    }

    public void setDropLat1(String rate) {
        editor.putString(KEY_DROP_LAT1, rate);
        editor.commit();

    }

    public String getDropLong1() {
        return pref.getString(KEY_DROP_LONG1, null);
    }

    public void setDropLong1(String rate) {
        editor.putString(KEY_DROP_LONG1, rate);
        editor.commit();
    }

    public String getDropAt1() {
        return pref.getString(KEY_DROP_AT1, null);
    }

    public void setDropAt1(String drop) {
        editor.putString(KEY_DROP_AT1, drop);
        editor.commit();
    }

    public String getPickAt1() {
        return pref.getString(KEY_PICK_UP1, null);
    }

    public void setPickAt1(String drop) {
        editor.putString(KEY_PICK_UP1, drop);
        editor.commit();
    }

    public String getPickLat1() {
        return pref.getString(KEY_PICK_LAT1, null);
    }

    public void setPickLat1(String rate) {
        editor.putString(KEY_PICK_LAT1, rate);
        editor.commit();

    }

    public String getPickLong1() {
        return pref.getString(KEY_PICK_LONG1, null);
    }

    public void setPickLong1(String rate) {
        editor.putString(KEY_PICK_LONG1, rate);
        editor.commit();
    }

    public String getClostingTime2() {
        return pref.getString(KEY_CLOSE2, null);
    }


    public void setClostingTime2(String cost) {
        editor.putString(KEY_CLOSE2, cost);
        editor.commit();
    }

    public String getOpeningTime2() {
        return pref.getString(KEY_OPEN2, null);
    }


    public void setOpeningTime2(String cost) {
        editor.putString(KEY_OPEN2, cost);
        editor.commit();
    }

    public String getClostingTime3() {
        return pref.getString(KEY_CLOSE3, null);
    }


    public void setClostingTime3(String cost) {
        editor.putString(KEY_CLOSE3, cost);
        editor.commit();
    }

    public String getOpeningTime3() {
        return pref.getString(KEY_OPEN3, null);
    }


    public void setOpeningTime3(String cost) {
        editor.putString(KEY_OPEN3, cost);
        editor.commit();
    }

    public String getClostingTime4() {
        return pref.getString(KEY_CLOSE4, null);
    }


    public void setClostingTime4(String cost) {
        editor.putString(KEY_CLOSE4, cost);
        editor.commit();
    }

    public String getOpeningTime4() {
        return pref.getString(KEY_OPEN4, null);
    }


    public void setOpeningTime4(String cost) {
        editor.putString(KEY_OPEN4, cost);
        editor.commit();
    }

    public String getTotal() {
        return pref.getString(TOTAL, null);
    }

    public void setTotal(String total) {
        editor.putString(TOTAL, total);
        editor.commit();
    }

    public String getTotal2() {
        return pref.getString(TOTA2L, null);
    }

    public void setTotal2(String total) {
        editor.putString(TOTA2L, total);
        editor.commit();
    }

    public float getDistance() {
        return pref.getFloat(DISTANCE, 0);
    }

    public void setDistance(float distance) {
        editor.putFloat(DISTANCE, distance);
        editor.commit();
    }

    public int getOTP() {
        return pref.getInt(OTP, 0);
    }

    public void setOTP(int msgNo) {
        editor.putInt(OTP, msgNo);
        editor.commit();
    }

    public int getOffline() {
        return pref.getInt(KEY_OFFLINE, 0);
    }

    public void setOffline(int i) {
        editor.putInt(KEY_OFFLINE, i);
        editor.commit();
    }

    public String getCost() {
        return pref.getString(COST, null);
    }

    public void setCost(String token) {
        editor.putString(COST, token);
        editor.commit();
    }

    public String getOrder() {
        return pref.getString(NEW_ORDER, null);
    }

    public void setOrder(String token) {
        editor.putString(NEW_ORDER, token);
        editor.commit();
    }

    public int getGoTRide() {
        return pref.getInt(NEW_GOTRIDE, 0);
    }

    public void setGoTRide(int imp) {
        editor.putInt(NEW_GOTRIDE, imp);
        editor.commit();
    }

    public String getVehicleNo() {
        return pref.getString(_VEHICLE, null);
    }

    public void setVehicleNo(String no1) {
        editor.putString(_VEHICLE, no1);
        editor.commit();
    }

    public float getStar() {
        return pref.getFloat(NEW_STAR, 0);
    }

    public void setStar(float star) {
        editor.putFloat(NEW_STAR, star);
        editor.commit();
    }

    public int getSavedAddress() {
        return pref.getInt(SAVEDADDRESS, 0);
    }

    public void setSavedAddress(int imp) {
        editor.putInt(SAVEDADDRESS, imp);
        editor.commit();
    }

    public int getPayment() {
        return pref.getInt(PAYMENT, 0);
    }

    public void setPayment(int i) {
        editor.putInt(PAYMENT, i);
        editor.commit();
    }

    public String getWhatsApp() {
        return pref.getString(WHATSAPP, null);
    }

    public void setWhatsApp(String whatsApp) {
        editor.putString(WHATSAPP, whatsApp);
        editor.commit();
    }

    public String getYoutubeVideos() {
        return pref.getString(YOUTUBES, null);
    }

    public void setYoutubeVideos(String whatsApp) {
        editor.putString(YOUTUBES, whatsApp);
        editor.commit();
    }

    public String getFacebook() {
        return pref.getString(FACEBOOK, null);
    }

    public void setFacebook(String whatsApp) {
        editor.putString(FACEBOOK, whatsApp);
        editor.commit();
    }

    public String getInstagram() {
        return pref.getString(INSTAGRAM, null);
    }

    public void setInstagram(String whatsApp) {
        editor.putString(INSTAGRAM, whatsApp);
        editor.commit();
    }
}