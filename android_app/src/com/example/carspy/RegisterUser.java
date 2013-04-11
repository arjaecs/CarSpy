package com.example.carspy;

import static com.example.carspy.Constants.*;

import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.app.ActionBar;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;

public class RegisterUser extends Activity implements OnClickListener {	
	private Button btnRegister;
	private Button btnCancel;
	private Button btnUserInfo;
	private Button btnVehicleInfo;
	private ImageView imgButtonUserInfo;
	private ImageView imgButtonVehicleInfo;
	private TableLayout tblUserText;
	private TableLayout tblVehicleText;
	private TableLayout tblUserTextBoxes;
	private TableLayout tblVehicleTextBoxes;
	private EditText txbFName;
	private EditText txbLName;
	private EditText txbEmail;
	private EditText txbGender;
	private EditText txbBDay;
	private EditText txbPhone;
	private EditText txbAddress;
	private EditText txbPassword;
	private EditText txbDeviceID;
	private EditText txbMake;
	private EditText txbModel;
	private EditText txbYear;
	private EditText txbColor;
	private EditText txbLicensePlate;

	private ProgressDialog pDialog;

	private JSONParser jsonParser;

	private String userID;
	private String firstName;
	private String lastName;
	private String email;
	private String gender;
	private String birth;
	private String phone;
	private String address;
	private String password;
	private String vehicleID;
	private String make;
	private String model;
	private String year;
	private String color;
	private String licensePlate;

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.register_user);

		ActionBar actionBar = getActionBar();
		actionBar.hide();		

		jsonParser = new JSONParser();

		initializeVisualComponents();
	}

	public void onClick(View v) {
		if (v.getId() == R.id.btnCancel) {
			Intent loginActivity = new Intent(RegisterUser.this, Login.class);
			startActivity(loginActivity);
		}
		else if (v.getId() == R.id.btnRegister) {	
			firstName = "1234"; //txbFName.getText().toString();
			lastName = "1234"; //txbLName.getText().toString();
			email = "1234"; //txbEmail.getText().toString();
			gender = "1234"; //txbGender.getText().toString();
			birth = "1234"; //txbBDay.getText().toString();
			phone = "1234"; //txbPhone.getText().toString();
			address = "1234"; //txbAddress.getText().toString();
			password = "1234"; //txbPassword.getText().toString();
			vehicleID = "4"; //txbDeviceID.getText().toString();
			make = "1234"; //txbMake.getText().toString();
			model = "1234"; //txbModel.getText().toString();
			year = "1234"; //txbYear.getText().toString();
			color = "1234"; //txbColor.getText().toString();
			licensePlate = "1234"; //txbLicensePlate.getText().toString();

			if (!firstName.equals("") && !lastName.equals("") && !email.equals("") && !gender.equals("") && !birth.equals("")
					&& !phone.equals("") && !address.equals("") && !password.equals("")
					&& !vehicleID.equals("") && !make.equals("") && !model.equals("") && !year.equals("") 
					&& !color.equals("") && !licensePlate.equals("")) {
				new VerifyDeviceID().execute();
			} 
			else {
				pDialog = Miscellaneous.OKProgressDialog(RegisterUser.this, "All user and vehicle information must be filled.");
				pDialog.show();
			}
		}
		else if (v.getId() == R.id.btnUserInfo) {
			btnUserInfo.setTextColor(Color.BLACK);
			btnVehicleInfo.setTextColor(Color.GRAY);
			imgButtonVehicleInfo.setVisibility(View.INVISIBLE);
			imgButtonUserInfo.setVisibility(View.VISIBLE);
			tblUserText.setVisibility(View.VISIBLE);
			tblUserTextBoxes.setVisibility(View.VISIBLE);
			tblVehicleText.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
		}
		else if (v.getId() == R.id.btnVehicleInfo) {
			btnVehicleInfo.setTextColor(Color.BLACK);
			btnUserInfo.setTextColor(Color.GRAY);
			imgButtonUserInfo.setVisibility(View.INVISIBLE);
			imgButtonVehicleInfo.setVisibility(View.VISIBLE);
			tblUserText.setVisibility(View.INVISIBLE);
			tblUserTextBoxes.setVisibility(View.INVISIBLE);
			tblVehicleText.setVisibility(View.VISIBLE);
			tblVehicleTextBoxes.setVisibility(View.VISIBLE);
		}
	}

	private void initializeVisualComponents() {
		btnRegister = (Button) findViewById(R.id.btnRegister);
		btnCancel = (Button) findViewById(R.id.btnCancel);
		btnUserInfo = (Button) findViewById(R.id.btnUserInfo);
		btnVehicleInfo = (Button) findViewById(R.id.btnVehicleInfo);

		imgButtonUserInfo = (ImageView) findViewById(R.id.imgButtonUserInfo);
		imgButtonVehicleInfo = (ImageView) findViewById(R.id.imgButtonVehicleInfo);

		tblUserText = (TableLayout) findViewById(R.id.tblUserText);
		tblVehicleText = (TableLayout) findViewById(R.id.tblVehicleText);
		tblUserTextBoxes = (TableLayout) findViewById(R.id.tblUserTextBoxes);
		tblVehicleTextBoxes = (TableLayout) findViewById(R.id.tblVehicleTextBoxes);

		txbFName = (EditText) findViewById(R.id.txbFName);
		txbLName = (EditText) findViewById(R.id.txbLName);
		txbEmail = (EditText) findViewById(R.id.txbEmail);
		txbGender = (EditText) findViewById(R.id.txbGender);
		txbBDay = (EditText) findViewById(R.id.txbBDay);
		txbPhone = (EditText) findViewById(R.id.txbPhone);
		txbAddress = (EditText) findViewById(R.id.txbAddress);
		txbPassword = (EditText) findViewById(R.id.txbPassword);

		txbDeviceID = (EditText) findViewById(R.id.txbDeviceID);
		txbMake = (EditText) findViewById(R.id.txbMake);
		txbModel = (EditText) findViewById(R.id.txbModel);
		txbYear = (EditText) findViewById(R.id.txbYear);
		txbColor = (EditText) findViewById(R.id.txbColor);
		txbLicensePlate = (EditText) findViewById(R.id.txbLicensePlate);

		btnRegister.setOnClickListener(this);
		btnCancel.setOnClickListener(this);
		btnUserInfo.setOnClickListener(this);
		btnVehicleInfo.setOnClickListener(this);
	}

	class VerifyDeviceID extends AsyncTask<String, String, JSONObject> {

		@Override
		protected void onPreExecute() {
			super.onPreExecute();

			pDialog = Miscellaneous.NormalProgressDialog(RegisterUser.this, "Verifying if vehicle ID exists in database.");
			pDialog.show();
		}

		protected JSONObject doInBackground(String... params) {
			int success;
			JSONObject vehicleJObj = new JSONObject();

			try {
				List<NameValuePair> tempParam= new ArrayList<NameValuePair>();
				tempParam.add(new BasicNameValuePair(VEHICLE_ID, vehicleID));
				JSONObject json = jsonParser.makeHttpRequest(GET_VEHICLE_ID, "GET", tempParam);

				success = json.getInt(TAG_SUCCESS);
				if (success == 1) {
					// Successfully received product details.
					JSONArray vehicleJObjArray = json.getJSONArray(TAG_VEHICLE); // JSON Array

					vehicleJObj = vehicleJObjArray.getJSONObject(0);
				}
				else {
					// Vehicle with that vehicleID not found.
					return vehicleJObj;
				}
			} 
			catch (JSONException e) {
				e.printStackTrace();
				Log.d(getClass().getName(), e.getMessage());
				return vehicleJObj;
			}

			return vehicleJObj;
		}

		protected void onPostExecute(JSONObject jObj) {
			pDialog.dismiss();

			try {
				String dbDeviceID = "";
				String dbMake = "";
				String dbModel = "";

				if (jObj.has(VEHICLE_ID) && jObj.has(MAKE) && jObj.has(MODEL)) {
					dbDeviceID = jObj.getString(VEHICLE_ID);
					dbMake = jObj.getString(MAKE);
					dbModel = jObj.getString(MODEL);
				}

				if (!dbDeviceID.isEmpty() && dbMake.equals("Make") && dbModel.equals("Model")) {
					new InsertUser().execute();
				}
				else {
					ProgressDialog newDialog = Miscellaneous.OKProgressDialog(RegisterUser.this, "Device ID is already in use.");
					newDialog.show();

					//pDialog = Miscellaneous.OKProgressDialog(RegisterUser.this, "Device ID is already in use.");
					//pDialog.show();
				}
			} 
			catch (JSONException e) {
				Log.d(getClass().getName(), "Error: " + e.getMessage());
			}
		}
	}

	class InsertUser extends AsyncTask<String, String, String> {

		@Override
		protected void onPreExecute() {
			super.onPreExecute();

			pDialog = Miscellaneous.NormalProgressDialog(RegisterUser.this, "Saving new user and vehicle information.");
			pDialog.show();
		}

		protected String doInBackground(String... params) {
			int success;
			String result = "0";

			try {
				password = Miscellaneous.getMD5(password);
				
				List<NameValuePair> tempParam= new ArrayList<NameValuePair>();
				tempParam.add(new BasicNameValuePair(FIRST_NAME, firstName));
				tempParam.add(new BasicNameValuePair(LAST_NAME, lastName));
				tempParam.add(new BasicNameValuePair(EMAIL, email));
				tempParam.add(new BasicNameValuePair(PASSWORD, password));
				tempParam.add(new BasicNameValuePair(GENDER, gender));
				tempParam.add(new BasicNameValuePair(BIRTH, birth));
				tempParam.add(new BasicNameValuePair(PHONE, phone));
				tempParam.add(new BasicNameValuePair(ADDRESS, address));

				JSONObject json = jsonParser.makeHttpRequest(INSERT_USER, "POST", tempParam);

				success = json.getInt(TAG_SUCCESS);
				if (success == 1) {
					result = "1";
				}
			} 
			catch (JSONException e) {
				Log.d(getClass().getName(), e.getMessage());
			}

			return result;
		}

		protected void onPostExecute(String result) {
			if (result.equals("1")) {
				new GetUserID().execute();
				new InsertVehicle().execute();

				Log.d(getClass().getName(), "User information has been successfully added.");
			}
			else {
				pDialog.dismiss();

				ProgressDialog newDialog =  Miscellaneous.OKProgressDialog(RegisterUser.this, "Email is already in use. Please provide another email address.");
				newDialog.show();

				//pDialog = Miscellaneous.OKProgressDialog(RegisterUser.this, "Email is already in use. Please provide another email address.");
				//pDialog.show();

				Log.d(getClass().getName(), "User informaton could not be added. Please try again later.");
			}
		}
	}

	class GetUserID extends AsyncTask<String, String, JSONObject> {

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
		}

		protected JSONObject doInBackground(String... params) {
			int success;
			JSONObject userJObj = new JSONObject();

			try {
				List<NameValuePair> tempParam= new ArrayList<NameValuePair>();
				tempParam.add(new BasicNameValuePair(EMAIL, email));
				JSONObject json = jsonParser.makeHttpRequest(GET_USER_ID, "GET", tempParam);

				success = json.getInt(TAG_SUCCESS);
				if (success == 1) {
					// Successfully received product details.
					JSONArray userJObjArray = json.getJSONArray(TAG_USER); // JSON Array

					userJObj = userJObjArray.getJSONObject(0);
				}
				else {
					// User with that email not found.
					return userJObj;
				}
			} 
			catch (JSONException e) {
				Log.d(getClass().getName(), e.getMessage());
				return userJObj;
			}

			return userJObj;
		}

		protected void onPostExecute(JSONObject jObj) {
			try {
				String dbUserID = "";

				if (jObj.has(USER_ID)) {
					dbUserID = jObj.getString(USER_ID);
				}

				userID = dbUserID;
			} 
			catch (JSONException e) {
				Log.d(getClass().getName(), "Error: " + e.getMessage());
			}
		}
	}

	class InsertVehicle extends AsyncTask<String, String, String> {

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
		}

		protected String doInBackground(String... params) {
			int success;
			String result = "0";

			try {
				List<NameValuePair> tempParam= new ArrayList<NameValuePair>();
				tempParam.add(new BasicNameValuePair(VEHICLE_ID, vehicleID));
				tempParam.add(new BasicNameValuePair(USER_ID, userID));
				tempParam.add(new BasicNameValuePair(MAKE, make));
				tempParam.add(new BasicNameValuePair(MODEL, model));
				tempParam.add(new BasicNameValuePair(COLOR, color));
				tempParam.add(new BasicNameValuePair(YEAR, year));
				tempParam.add(new BasicNameValuePair(LICENSE_PLATE, licensePlate));

				JSONObject json = jsonParser.makeHttpRequest(INSERT_VEHICLE, "POST", tempParam);

				success = json.getInt(TAG_SUCCESS);
				if (success == 1) {
					result = "1";
				}
			} 
			catch (JSONException e) {
				Log.d(getClass().getName(), e.getMessage());
			}

			return result;
		}

		protected void onPostExecute(String result) {
			pDialog.dismiss();

			if (result.equals("1")) {
				ProgressDialog newDialog = new ProgressDialog(RegisterUser.this); 
				newDialog.setCanceledOnTouchOutside(false);
				newDialog.setMessage("User and vehicle information has been successfully added.");
				newDialog.setButton(DialogInterface.BUTTON_NEGATIVE, "OK", new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						dialog.dismiss();
						Intent mainActivity = new Intent(RegisterUser.this, Main.class);
						startActivity(mainActivity);
					}
				});
				newDialog.show();
			}
			else {

				ProgressDialog newDialog = Miscellaneous.OKProgressDialog(RegisterUser.this, "User and vehicle informaton could not be added. Please try again later.");
				newDialog.show();
			}
		}
	}

}
