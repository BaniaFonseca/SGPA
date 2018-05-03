package unilurio_fe.fe_esimop_ac.temp_methods;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import unilurio_fe.fe_esimop_ac.R;

/**
 * Created by acer on 20-Aug-15.
 */
public class Lista_Customizada extends ArrayAdapter<String> {

        private final Activity context;
        private final String[] web;
        private final Integer[] imageId;

       public Lista_Customizada(Activity context,
                          String[] web, Integer[] imageId) {
            super(context, R.layout.list_simples, web);
            this.context = context;
            this.web = web;
            this.imageId = imageId;

        }


        @Override
        public View getView(int position, View view, ViewGroup parent) {
            LayoutInflater inflater = context.getLayoutInflater();
            View rowView= inflater.inflate(R.layout.list_simples, null, true);
            TextView txtTitle = (TextView) rowView.findViewById(R.id.txt1);
            //TextView txtContente = (TextView) rowView.findViewById(R.id.txt2);

            ImageView imageView = (ImageView) rowView.findViewById(R.id.img);
            txtTitle.setText(web[position]);

            imageView.setImageResource(imageId[position]);
            return rowView;
        }
    }

