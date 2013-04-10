package com.example.carspy;

public final class Constants {
	//PHP URL's
	public static final String GET_USER_CREDENTIALS = "http://136.145.116.58/android_connect/get_user_credentials.php";
	public static final String UPDATE_PASSWORD = "http://136.145.116.58/android_connect/update_password.php";
	public static final String GET_VEHICLE_ID = "http://136.145.116.58/android_connect/get_vehicle_id.php";
	public static final String INSERT_USER = "http://136.145.116.58/android_connect/insert_user.php";
	public static final String GET_USER_ID = "http://136.145.116.58/android_connect/get_user_id.php";
	public static final String INSERT_VEHICLE = "http://136.145.116.58/android_connect/insert_vehicle.php";
	public static final String SEND_EMAIL = "http://136.145.116.58/android_connect/send_email.php";
	
	//JSON Constants
	public static final String TAG_SUCCESS = "success";
	public static final String TAG_USER = "user";
	public static final String TAG_VEHICLE = "vehicle";
	
    //User Table
    public static final String USER_ID = "userID";
    public static final String PASSWORD = "password";
    public static final String FIRST_NAME = "firstName";
    public static final String LAST_NAME = "lastName";
    public static final String EMAIL = "email";
    public static final String PHONE = "phone";
    public static final String BIRTH = "birth";
    public static final String GENDER = "gender";
    public static final String ADDRESS = "address";
    
    //Vehicle Table
    public static final String VEHICLE_ID = "vehicleID";
    public static final String MAKE = "make";
    public static final String MODEL = "model";
    public static final String YEAR = "year";
    public static final String COLOR = "color";
    public static final String LICENSE_PLATE = "licensePlate";
}
