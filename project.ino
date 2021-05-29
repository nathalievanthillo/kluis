#include <ESP8266WiFi.h>
#include <Servo.h>

//Call to ESpressif SDK
extern "C" {
  #include <user_interface.h>
}

//Hieronder kan je de SSID en Wachtwoord instellen.
const char* ssid     = "Kevin";
const char* password = "ww";

uint8_t mac[6] {0x5C, 0xCF, 0x7F, 0x80, 0x57, 0x97};


const char* host = "project-kluis.vanthillonathalie.be";

void setup() {
  Serial.begin(115200);
  Serial.println();
  
  //De volgende lijn veranderd het MAC adres van de ESP8266
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
  String url = "/index.htm";
  Serial.print("Requesting URL: ");
  Serial.println(url);
  
  // Get naar de host sturen:
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  delay(500);
  
  // Alles lezen en afprinten naar de seriele poort.
  // Merk op dat ook de antwoord headers worden afgedrukt!
  while(client.available()){
    String line = client.readStringUntil('\n');
    Serial.println(line);
  }

  // De verbinding met de server sluiten 
  Serial.println();
  Serial.println("closing connection");
  client.stop();
  delay(30000);
}
