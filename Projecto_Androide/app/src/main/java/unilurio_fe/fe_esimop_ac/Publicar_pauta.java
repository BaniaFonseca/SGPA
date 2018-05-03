package unilurio_fe.fe_esimop_ac;

import android.app.Activity;
import android.app.ListActivity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.Gson;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.serialization.SoapPrimitive;
import org.ksoap2.serialization.SoapSerializationEnvelope;
import org.ksoap2.transport.HttpTransportSE;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.text.ParseException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import javax.xml.transform.Result;

import unilurio_fe.fe_esimop_ac.temp_methods.JSONParser;
import unilurio_fe.fe_esimop_ac.temp_methods.Lista_Customizada;
import unilurio_fe.fe_esimop_ac.temp_methods.Lista_Disciplinas;
import unilurio_fe.fe_esimop_ac.temp_methods.SessionManager;


public class Publicar_pauta extends ActionBarActivity {

    private ListView listView;
    private String[] disp;
    private String[] av;
    private Integer[] imageId;
    private int qtd = 4;


    SessionManager session;
    private String TAG="Cargo";
    //String contentType = "application/json";
    ListView lv;
    private static String responseJSON;

    Gson gson=new Gson();
    private final String NAMESPACE = "http://tempuri.org/";
    private static String METHOD_NAME_LOGIN= "login";

    private final String SOAP_ACTION = "http://tempuri.org/";
    private static String URL = "http://10.0.2.2/unilurio_fe/eSimop-ac.mz/view/login_android.php";
    private static final String SOAP_ACTION_LOGIN = "http://10.0.2.2/unilurio_fe/eSimop-ac.mz/view/login_android.php";

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_publicar_pauta);
        listView = (ListView)findViewById(R.id.listView_disp);
        TextView texto = (TextView) findViewById(R.id.textView2);


        disp = new String[qtd];
        av = new String[qtd];
        imageId = new Integer[qtd];

        for(int i=0; i< qtd; i++){

            disp[i] = "PRO "+i;
            av[i] = "2 - Avaliações";
            imageId[i] = R.drawable.abc_btn_check_to_on_mtrl_015;
         }

         listView.setAdapter(new Lista_Disciplinas(this,imageId,disp,av));
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

}