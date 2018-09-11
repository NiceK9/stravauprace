/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package upracetools;

import com.fasterxml.jackson.databind.ObjectMapper;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.security.Timestamp;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import javafx.application.Application;
import static javafx.application.Application.launch;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;
import upracetools.NetworkUltility;
import upracetools.data.Activity;
import upracetools.data.Profile;
import upracetools.data.UserProfileRespone;
import upracetools.data.strava.subcription.SubscriptionBuilder;
import upracetools.data.strava.subcription.SubscriptionRequest;

/**
 *
 * @author nice
 */
public class UpRaceTools extends Application {

    @Override
    public void start(Stage stage) throws Exception {
        URL url = getClass().getResource("/FXMLDocument.fxml");
        Parent root = FXMLLoader.load(url);

        Scene scene = new Scene(root);

        stage.setScene(scene);
        stage.show();
    }
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        launch(args);
//        new UpRaceTools();
    }  
    
    public class JavaFXApplication1 extends Application {

        @Override
        public void start(Stage stage) throws Exception {
            Parent root = FXMLLoader.load(getClass().getResource("FXMLDocument.fxml"));

            Scene scene = new Scene(root);

            stage.setScene(scene);
            stage.show();
        }

//        /**
//         * @param args the command line arguments
//         */
//        public static void main(String[] args) {
//            launch(args);
//        }

    }

}
