package com.example.carspy;

import java.util.ArrayList;
import java.util.List;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.ActionBar;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import static com.example.carspy.Constants.*;

public class Login extends Activity implements OnClickListener {
	private Button btnLogin;
	private Button btnNotRegistered;
	private Button btnLostPassword;
	private EditText txbEmail;
	private EditText txbPassword;
	private ProgressDialog pDialog;
	private JSONParser jsonParser;

	private String email;
	private String password;
	private String newPassword;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login);

		ActionBar actionBar = getActionBar();
		actionBar.hide();

		btnLogin = (Button) findViewById(R.id.btnLogin);
		btnLogin.setOnClickListener(this);

		txbEmail = (EditText) findViewById(R.id.txbEmail);
		txbPassword = (EditText) findViewById(R.id.txbPassword);

		btnNotRegistered = (Button) findViewById(R.id.btnNotRegistered);
		btnNotRegistered.setOnClickListener(this);

		btnLostPassword = (Button) findViewById(R.id.btnLostPassword);
		btnLostPassword.setOnClickListener(this);
		
		jsonParser = new JSONParser();
	}


	class VerifyUserCredentials extends AsyncTask<String, String, JSONObject> {

		@Override
		protected void onPreExecute() {
			super.onPreExecute();

			pDialog = new ProgressDialog(Login.this); 
			pDialog.setCanceledOnTouchOutside(false);
			pDialog.setMessage("Verifying user credentials.");
			pDialog.setIndeterminate(false);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		protected JSONObject doInBackground(String... params) {
			int success;
			JSONObject userJObj = new JSONObject();

			try {
				List<NameValuePair> tempParam= new ArrayList<NameValuePair>();
				tempParam.add(new BasicNameValuePair(EMAIL, email));
				JSONObject json = jsonParser.makeHttpRequest(GET_USER_CREDENTIALS, "GET", tempParam);

				success = json.getInt(TAG_SUCCESS);
				if (success == 1) {
					// successfully received product details
					JSONArray userJObjArray = json.getJSONArray(TAG_USER); // JSON Array

					// get first product object from JSON Array
					userJObj = userJObjArray.getJSONObject(0);
				}
				else {
					// User with that email not found.
					return userJObj;
				}
			} 
			catch (JSONException e) {
				e.printStackTrace();
				Log.d(getClass().getName(), e.getMessage());
				return userJObj;
			}

			return userJObj;
		}

		protected void onPostExecute(JSONObject jObj) {
			pDialog.dismiss();

			try {
				String dbEmail = "";
				String dbPassword = "";

				if (jObj.has(EMAIL) && jObj.has(PASSWORD)) {
					dbEmail = jObj.getString(EMAIL);
					dbPassword = jObj.getString(PASSWORD);
				}

				password = Miscellaneous.getMD5(password);

				if (dbEmail.isEmpty() || !password.equals(dbPassword))  {
					txbPassword.setText("");

					pDialog = new ProgressDialog(Login.this); 
					pDialog.setCanceledOnTouchOutside(false);
					pDialog.setMessage("Incorrect email or password.");
					pDialog.setButton(DialogInterface.BUTTON_NEGATIVE, "OK", new DialogInterface.OnClickListener() {
						@Override
						public void onClick(DialogInterface dialog, int which) {
							dialog.dismiss();
						}
					});
					pDialog.show();
				}
				else {
					Intent mainActivity = new Intent(Login.this, Main.class);
					startActivity(mainActivity);
				}
			} catch (JSONException e) {
				e.printStackTrace();
			}
		}
	}


	class LostPasswordConfirmation extends AsyncTask<String, String, JSONObject> {

		@Override
		protected void onPreExecute() {
			super.onPreExecute();

			pDialog = new ProgressDialog(Login.this); 
			pDialog.setCanceledOnTouchOutside(false);
			pDialog.setMessage("Verifying user email.");
			pDialog.setIndeterminate(false);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		protected JSONObject doInBackground(String... params) {
			int success;
			JSONObject userJObj = new JSONObject();

			try {
				List<NameValuePair> tempParam= new ArrayList<NameValuePair>();
				tempParam.add(new BasicNameValuePair(EMAIL, email));
				JSONObject json = jsonParser.makeHttpRequest(GET_USER_CREDENTIALS, "GET", tempParam);

				success = json.getInt(TAG_SUCCESS);
				if (success == 1) {
					// successfully received product details
					JSONArray userJObjArray = json.getJSONArray(TAG_USER); // JSON Array

					// get first product object from JSON Array
					userJObj = userJObjArray.getJSONObject(0);
				}
				else {
					// User with that email not found.
					return userJObj;
				}
			} 
			catch (JSONException e) {
				e.printStackTrace();
				return userJObj;
			}

			return userJObj;
		}

		protected void onPostExecute(JSONObject jObj) {
			pDialog.dismiss();

			try {
				String dbEmail = "";

				if (jObj.has(EMAIL)) {
					dbEmail = jObj.getString(EMAIL);
				}

				if (dbEmail.isEmpty())  {
					txbPassword.setText("");

					pDialog = new ProgressDialog(Login.this); 
					pDialog.setCanceledOnTouchOutside(false);
					pDialog.setMessage("Please provide a registered email to reset your password.");
					pDialog.setButton(DialogInterface.BUTTON_NEGATIVE, "OK", new DialogInterface.OnClickListener() {
						@Override
						public void onClick(DialogInterface dialog, int which) {
							dialog.dismiss();
						}
					});
					pDialog.show();
				}
				else {
					pDialog = new ProgressDialog(Login.this); 
					pDialog.setCanceledOnTouchOutside(false);
					pDialog.setMessage("Do you want to reset your password?");
					pDialog.setButton(DialogInterface.BUTTON_POSITIVE, "Yes", new DialogInterface.OnClickListener() {
						@Override
						public void onClick(DialogInterface dialog, int which) {
							newPassword = Miscellaneous.generatePassword();
							Log.d(getClass().getName(), newPassword);
							//TODO: Send email with new password BEFORE saving in DB.
							newPassword = Miscellaneous.getMD5(newPassword);
							Log.d(getClass().getName(), newPassword);
							new ResetPassword().execute();

							dialog.dismiss();
						}
					});
					pDialog.setButton(DialogInterface.BUTTON_NEGATIVE, "No", new DialogInterface.OnClickListener() {
						@Override
						public void onClick(DialogInterface dialog, int which) {
							dialog.dismiss();
						}
					});
					pDialog.show();
				}
			} catch (JSONException e) {
				e.printStackTrace();
			}
		}
	}

	class ResetPassword extends AsyncTask<String, String, String> {

		@Override
		protected void onPreExecute() {
			super.onPreExecute();

			pDialog = new ProgressDialog(Login.this); 
			pDialog.setCanceledOnTouchOutside(false);
			pDialog.setMessage("Resetting password.");
			pDialog.setIndeterminate(false);
			pDialog.setCancelable(true);
			pDialog.show();
		}

		protected String doInBackground(String... params) {
			int success;
			String result = "0";

			try {
				List<NameValuePair> tempParam= new ArrayList<NameValuePair>();
				tempParam.add(new BasicNameValuePair(EMAIL, email));
				tempParam.add(new BasicNameValuePair(PASSWORD, newPassword));

				JSONObject json = jsonParser.makeHttpRequest(UPDATE_PASSWORD, "POST", tempParam);

				success = json.getInt(TAG_SUCCESS);
				if (success == 1) {
					result = "1";
				}
			} 
			catch (JSONException e) {
				e.printStackTrace();
			}

			return result;
		}

		protected void onPostExecute(String result) {
			pDialog.dismiss();

			if (result.equals("1")) {
				pDialog = new ProgressDialog(Login.this); 
				pDialog.setCanceledOnTouchOutside(false);
				pDialog.setMessage("An email has been sent with the resetted password.");
				pDialog.setButton(DialogInterface.BUTTON_NEGATIVE, "OK", new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						dialog.dismiss();
					}
				});
				pDialog.show();
			}
			else {
				pDialog = new ProgressDialog(Login.this); 
				pDialog.setCanceledOnTouchOutside(false);
				pDialog.setMessage("Password could not be resetted. Please try again later.");
				pDialog.setButton(DialogInterface.BUTTON_NEGATIVE, "OK", new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						dialog.dismiss();
					}
				});
				pDialog.show();
			}
		}
	}

	public void onClick(View v) {
		if (v.getId() == R.id.btnLogin) {
			email = Login.this.txbEmail.getText().toString();
			password = Login.this.txbPassword.getText().toString();

			new VerifyUserCredentials().execute();
		}

		else if (v.getId() == R.id.btnNotRegistered) {
			Intent registerUserActivity = new Intent(Login.this, RegisterUser.class);
			startActivity(registerUserActivity);
		}
		else if (v.getId() == R.id.btnLostPassword) {
			email = Login.this.txbEmail.getText().toString();
			new LostPasswordConfirmation().execute();
		}
	}

}
