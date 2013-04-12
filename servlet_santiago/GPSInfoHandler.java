
public class GPSInfoHandler {

	private static String time;
	private static boolean isValid; //Needs to be taken into account when inserting to DB.
	private static String latitude;
	private static String longitude;
	private static String date;

	// To test individual components.
	public static void main(String[] args) {
		String gpsInfo = "$GPRMC,064951.000,A,2307.1256,N,12016.4438,E,0.03,165.48,260406,3.05,W,A*2C";
		setGPSInfo(gpsInfo);
	}
	
	public static void setGPSInfo(String gpsString) {
		String[] tokens = gpsString.split(",");

		time = tokens[1];
		time = time.substring(0, 2) + ":" + time.substring(2, 4) + ":" + time.substring(4, 6);

		isValid = tokens[2].equals("A");

		latitude = tokens[3].replace(".", "");
		latitude = latitude.substring(0, 2) + "." + latitude.substring(2);
		if (tokens[4].equals("S")) {
			latitude = "-" + latitude;
		}

		longitude = tokens[5].replace(".", "");
		longitude = longitude.substring(0, 2) + "." + longitude.substring(2);
		if (tokens[6].equals("W")) {
			longitude = "-" + longitude;
		}
		
		date = tokens[9];
		date = date.substring(4, 6) + "-" + date.substring(2, 4) + "-" + date.substring(0, 2);
		
		System.out.println("Time: " + time + " | Valid: " + isValid + " | Lat: " + latitude + " | Long: " + longitude  + " | Date: " + date);
	}

	public static String getTime() {
		return time;
	}

	public static boolean isValid() {
		return isValid;
	}

	public static String getLatitude() {
		return latitude;
	}

	public static String getLongitude() {
		return longitude;
	}

	public static String getDate() {
		return date;
	}
	
	
}
