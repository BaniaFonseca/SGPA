package unilurio_fe.fe_esimop_ac.temp_methods;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.List;

import unilurio_fe.fe_esimop_ac.R;

/**
 * Created by acer on 21-Aug-15.
 */
public class Lista_Disciplinas extends ArrayAdapter<String>  {


    private  Activity activity;
    private  Integer[] img;
    private  String[] disp;
    private  String[] av;


    public Lista_Disciplinas(Activity activity) {
        super(activity, R.layout.lista_disciplina);

    }


    public Lista_Disciplinas(Activity activity, Integer[] img, String[] disp, String[] av) {
        super(activity, R.layout.lista_disciplina, disp);

        this.activity = activity;
        this.img = img;
        this.disp = disp;
        this.av = av;
    }

    public Activity getActivity() {
        return activity;
    }

    public void setActivity(Activity activity) {
        this.activity = activity;
    }

    public Integer[] getImg() {
        return img;
    }

    public void setImg(Integer[] img) {
        this.img = img;
    }

    public String[] getDisp() {
        return disp;
    }

    public void setDisp(String[] disp) {
        this.disp = disp;
    }

    public String[] getAv() {
        return av;
    }

    public void setAv(String[] av) {
        this.av = av;
    }

    @Override
    public View getView(int position, View view, ViewGroup parent) {
        LayoutInflater inflater = activity.getLayoutInflater();

        View rowView= inflater.inflate(R.layout.lista_disciplina, null, true);

        TextView txtDisp = (TextView) rowView.findViewById(R.id.txt_disp);
        TextView txtAv = (TextView) rowView.findViewById(R.id.txt_av);

        ImageView imageView = (ImageView) rowView.findViewById(R.id.img);
        txtDisp.setText(disp[position]);
        txtAv.setText(av[position]);
        imageView.setImageResource(img[position]);

        return rowView;
    }
}
