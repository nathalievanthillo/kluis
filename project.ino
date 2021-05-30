#include <ESP8266WiFi.h>
#include <Servo.h>

//Call to ESpressif SDK
extern "C" {
  #include <user_interface.h>
}

// SSID en Wachtwoord instellen.
const char* ssid     = "Kevin";
const char* password = "vx5j5MCdmamb";

//Mac adress geset
uint8_t mac[6] {0x5C, 0xCF, 0x7F, 0x80, 0x57, 0x97};

//host name geset
const char* host = "project-kluis.vanthillonathalie.be";

//lege string om straks te gebruiken met info van de site
String line = "";
int servo = 4; // servo motor aangesloten op pin 4
int servoPosOpen = 135; // servo draait naar 100 graden
int servoPosLocked = 0; // de servo motor draait naar 0 graden
Servo servoLock; // naam van de servo motor

void setup() {
  Serial.begin(115200);
  Serial.println();
 servoLock.attach(servo); // link de naam van de servo motor met de pin (4)
  
  
  //verander het MAC adres van de ESP8266
  wifi_set_macaddr(0, const_cast<uint8*>(mac)); 
  
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  Serial.print("Bezig met connecteren...");
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println();

  Serial.print("Geconnecteerd!\nMijn IP adres: ");
  Serial.println(WiFi.localIP());
  Serial.printf("Mijn MAC adres is: %s\n", WiFi.macAddress().c_str());
  Serial.print("De gateway is: ");
  Serial.println(WiFi.gatewayIP());
  Serial.print("De DNS is: ");
  Serial.println(WiFi.dnsIP());
}


void loop() {
  Serial.print("connecting to ");
  Serial.println(host);

  // Probeer te connecteren met de host 
  WiFiClient client;
  client.setTimeout(1000);    //Nodig voor de timeout in readStringUntil
  const int httpPort = 80;    //Een webserver luistert op poort 80
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
 
  // Het path klaar maken van hetgeen we willen van de host 
  String url = "/open_close.txt";
  Serial.print("Requesting URL: ");
  Serial.println(url);
  
  // Get naar de host sturen:
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  delay(500);
  
    // Alles lezen en afprinten naar de seriele poort.
  while(client.available()){
   line = client.readStringUntil('\n');
    Serial.println(line);
  }

  if(line == "open"){ //als wat er in het .txt document "open" staat,
         servoLock.write(servoPosOpen); // de servo motor staat op 0 graden
      } else if (line == "close"){ //als wat er in het .txt document "close" staat,
          servoLock.write(servoPosLocked); // servo motor staat op 100 graden
      }
  
  

  // De verbinding met de server sluiten 
  Serial.println();
  Serial.println("closing connection");
  client.stop();
  delay(5000);
}