package com.liteafrica.izigourmet.Model;

/**
 * Created by parag on 02/01/18.
 */

public class Promo {


    private String Promo_Code;
    private double Discount_Value;


    public String getPromo_Code(int position) {
        return Promo_Code;
    }

    public void setPromo_Code(String Promo_Code) {
        this.Promo_Code = Promo_Code;
    }


    public double getDiscount_Value(int position) {
        return Discount_Value;
    }

    public void setDiscount_Value(double Discount_Value) {
        this.Discount_Value = Discount_Value;
    }


}

