package com.liteafrica.izigourmet.Model;

/**
 * Created by parag on 28/02/18.
 */

public class Contacts {

    public String Name, Message, Photo, Date, Time;
    public String Contacts;


    public String getName(int position) {
        return Name;
    }

    public void setName(String name) {
        Name = name;
    }

    public String getContacts(int position) {
        return Contacts;
    }

    public void setContacts(String contacts) {
        Contacts = contacts;
    }

    public String getMessage(int position) {
        return Message;
    }

    public void setMessage(String message) {
        Message = message;
    }

    public String getPhoto(int position) {
        return Photo;
    }

    public void setPhoto(String photo) {
        Photo = photo;
    }

    public String getDate(int position) {
        return Date;
    }

    public void setDate(String date) {
        Date = date;
    }

    public String getTime(int position) {
        return Time;
    }

    public void setTime(String time) {
        Time = time;
    }
}
