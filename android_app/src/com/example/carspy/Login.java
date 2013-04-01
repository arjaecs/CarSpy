package com.example.carspy;

import android.os.Bundle;
import android.app.ActionBar;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class Login extends Activity implements OnClickListener {
	Button btnLogin;
	Button btnNotRegistered;
	Button btnLostPassword;
	EditText txbEmail;
	EditText txbPassword;

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
	}

	public void onClick(View v) {
		if (v.getId() == R.id.btnLogin) {
			String username = Login.this.txbEmail.getText().toString();
			String password = Login.this.txbPassword.getText().toString();

			//TODO: Search username in DB, then search that username's password, return true if both are found.
			//if (username.equals("santiago") && password.equals("temetito"))  {
			Intent mainActivity = new Intent(Login.this, Main.class);
			startActivity(mainActivity);
			//}
			//else {
			//	Toast.makeText(this, "Incorrect Email Or Password.", Toast.LENGTH_LONG).show();
			//}
		}
		else if (v.getId() == R.id.btnNotRegistered) {
			Intent registerUserActivity = new Intent(Login.this, RegisterUser.class);
			startActivity(registerUserActivity);
		}
		else if (v.getId() == R.id.btnLostPassword) {
			//TODO: Verify email exist in DB.
			if(true /*emailExists*/) {

				AlertDialog.Builder builder = new AlertDialog.Builder(this);
				
				builder.setMessage("Did you forget your password?");
				builder.setPositiveButton("Yes", new DialogInterface.OnClickListener() {

					public void onClick(DialogInterface dialog, int which) {
						//TODO: Reset password and email it to the given email.
						ProgressDialog tempDialog = new ProgressDialog(Login.this);
						tempDialog.setMessage("An email has been sent with the reseted password.");
						tempDialog.setCancelable(true);
						tempDialog.setIndeterminate(false);
						tempDialog.show();

						dialog.dismiss();
					}

				});

				builder.setNegativeButton("No", new DialogInterface.OnClickListener() {

					@Override
					public void onClick(DialogInterface dialog, int which) {
						// Do nothing
						dialog.dismiss();
					}
				});

				AlertDialog alert = builder.create();
				alert.show();
			}
			else {
				Toast.makeText(this, "Please provide a registered email to reset your password.", Toast.LENGTH_LONG).show();
			}
		}
	}

}
