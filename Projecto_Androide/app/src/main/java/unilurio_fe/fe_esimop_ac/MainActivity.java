package unilurio_fe.fe_esimop_ac;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import unilurio_fe.fe_esimop_ac.temp_methods.Lista_Customizada;


public class MainActivity extends ActionBarActivity {

    private ListView listView;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        listView = (ListView)findViewById(R.id.listView_main);

        final String[] web = {
                "Publicar Pauta",
                "Plano de Avaliação",
                "Informações Gerais"

        } ;


        Integer[] imageId = {
                R.drawable.open_folder_24,
                R.drawable.google_web_search_24,
                R.drawable.home_24,



        };

        Lista_Customizada adapter = new
                Lista_Customizada(MainActivity.this, web, imageId);
        listView=(ListView)findViewById(R.id.listView_main);
        listView.setAdapter(adapter);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {


                switch (position){
                    case 0:
                        Intent intent = new Intent(getApplicationContext(),Publicar_pauta.class);
                        startActivity(intent);

                        break;
                    case 1:

                        Intent intent1 = new Intent(getApplicationContext(),Publicar_avaliacao.class);
                        startActivity(intent1);
                        break;
                    case 2:

                        Intent intent2 = new Intent(getApplicationContext(),Sobre_eSimop_ac.class);
                        startActivity(intent2);
                        break;
                    default: return;
                }

            }
        });

    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
