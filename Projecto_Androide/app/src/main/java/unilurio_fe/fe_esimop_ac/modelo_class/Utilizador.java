package unilurio_fe.fe_esimop_ac.modelo_class;

/**
 * Created by acer on 25-Aug-15.
 */
public class Utilizador {

    private String nsessao;
    private String username;
    private String password;
    private String fullname;
    private Integer  id;

    public Utilizador(){}

    public Utilizador(String nsessao, String username, String password, String fullname, Integer id) {
        this.nsessao = nsessao;
        this.username = username;
        this.password = password;
        this.fullname = fullname;
        this.id = id;
    }

    public String getNsessao() {
        return nsessao;
    }

    public void setNsessao(String nsessao) {
        this.nsessao = nsessao;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getFullname() {
        return fullname;
    }

    public void setFullname(String fullname) {
        this.fullname = fullname;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }
}
