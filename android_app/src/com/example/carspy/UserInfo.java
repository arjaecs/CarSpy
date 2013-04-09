package com.example.carspy;

import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.TableLayout;
import android.widget.TextView;
import android.widget.Toast;
import android.app.ActionBar;
import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;

public class UserInfo extends Activity implements OnClickListener {
	boolean startUp = false;
	Button btnSave;
	Button btnCancel;
	Button btnEditInfo;
	Button btnUserInfo;
	Button btnVehicleInfo;
	ImageView imgButtonDouble;
	ImageView imgButtonUserInfo;
	TableLayout tblUserText;
	TableLayout tblUserInfo;
	TableLayout tblUserTextBoxes;
	TextView txtFName;
	TextView txtLName;
	TextView txtEmail;
	TextView txtGender;
	TextView txtBDay;
	TextView txtPhone;
	TextView txtAddress;
	TextView txtPassword;
	EditText txbFName;
	EditText txbLName;
	EditText txbEmail;
	EditText txbGender;
	EditText txbBDay;
	EditText txbPhone;
	EditText txbAddress;
	EditText txbPassword;

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.user_info);

		ActionBar actionBar = getActionBar();
		actionBar.hide();		

		initializeVisualComponents();

		Spinner spinner = (Spinner) findViewById(R.id.spnOptions);
		ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource (this,
				R.array.options, R.drawable.spinner);
		adapter.setDropDownViewResource(R.drawable.spinner_dropdown);
		spinner.setAdapter(adapter);
		spinner.setOnItemSelectedListener(new OptionOnItemSelectedListener());
		spinner.setSelection(1);
	}

	private class OptionOnItemSelectedListener implements OnItemSelectedListener {

		public void onItemSelected(AdapterView<?> parent, View view, int pos,long id) {
			Spinner spinner = (Spinner) findViewById(R.id.spnOptions);
			String chosenOption = (String) spinner.getSelectedItem();
			
			if (chosenOption.equals("Home")) {
				Intent mainActivity = new Intent(UserInfo.this, Main.class);
				startActivity(mainActivity);
			}
			else if (chosenOption.equals("Logout")) {
				Intent loginActivity = new Intent(UserInfo.this, Login.class);
				startActivity(loginActivity);
			}
		}

		@Override
		public void onNothingSelected(AdapterView<?> arg0) {
			// TODO Auto-generated method stub
		}

	}

	public void onNothingSelected(AdapterView<?> parent) {
	}

	public void onClick(View v) {
		if (v.getId() == R.id.btnEditInfo) {
			btnEditInfo.setVisibility(View.INVISIBLE);
			btnSave.setVisibility(View.VISIBLE);
			btnCancel.setVisibility(View.VISIBLE);
			imgButtonDouble.setVisibility(View.VISIBLE);
			btnUserInfo.setClickable(false);
			btnVehicleInfo.setClickable(false);
			tblUserInfo.setVisibility(View.INVISIBLE);

			setEditableInfo();
		}
		else if (v.getId() == R.id.btnCancel) {
			btnSave.setVisibility(View.INVISIBLE);
			btnCancel.setVisibility(View.INVISIBLE);
			imgButtonDouble.setVisibility(View.INVISIBLE);
			btnEditInfo.setVisibility(View.VISIBLE);
			tblUserTextBoxes.setVisibility(View.INVISIBLE);
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);

			tblUserInfo.setVisibility(View.VISIBLE);

		}
		else if (v.getId() == R.id.btnSave) {
			//TODO: Update information in DB.
			//TODO: Extract info from DB to display again.
			Toast.makeText(this, "New information has been updated.", Toast.LENGTH_LONG).show();
			btnSave.setVisibility(View.INVISIBLE);
			btnCancel.setVisibility(View.INVISIBLE);
			imgButtonDouble.setVisibility(View.INVISIBLE);
			btnEditInfo.setVisibility(View.VISIBLE);
			tblUserTextBoxes.setVisibility(View.INVISIBLE);
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);

			tblUserInfo.setVisibility(View.VISIBLE);

		}
		else if (v.getId() == R.id.btnUserInfo) {
			btnUserInfo.setTextColor(Color.BLACK);
			btnVehicleInfo.setTextColor(Color.GRAY);
			imgButtonUserInfo.setVisibility(View.VISIBLE);
			tblUserText.setVisibility(View.VISIBLE);
			tblUserInfo.setVisibility(View.VISIBLE);
		}
		else if (v.getId() == R.id.btnVehicleInfo) {
			Intent vehicleInfoActivity = new Intent(UserInfo.this, VehicleInfo.class);
			startActivity(vehicleInfoActivity);
		}
		else if (v.getId() == R.id.btnRightArrow) {
			//			btnLeftArrow.setVisibility(View.VISIBLE);
			//
			//			//TODO: If user has multiple vehicles (DB).8
			//			if (false/*user has many vehicles*/) {
			//				//TODO: Show info of next vehicle (DB).
			//			}
			//			else {
			//				btnUserInfo.setClickable(false);
			//				btnVehicleInfo.setClickable(false);
			//				btnRightArrow.setVisibility(View.INVISIBLE);
			//				tblVehicleInfo.setVisibility(View.INVISIBLE);
			//				tblVehicleTextBoxes.setVisibility(View.VISIBLE);
			//				btnEditInfo.setVisibility(View.INVISIBLE);
			//				btnAddNewVehicle.setVisibility(View.VISIBLE);
			//			}
		}
		else if (v.getId() == R.id.btnLeftArrow) {
			//			btnUserInfo.setClickable(true);
			//			btnVehicleInfo.setClickable(true);
			//			
			//			if (tblVehicleTextBoxes.isShown()) {
			//				tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			//				btnEditInfo.setVisibility(View.INVISIBLE);
			//				btnAddNewVehicle.setVisibility(View.VISIBLE);
			//			}
			//			btnRightArrow.setVisibility(View.VISIBLE);
			//			btnEditInfo.setVisibility(View.VISIBLE);
			//			btnAddNewVehicle.setVisibility(View.INVISIBLE);
			//			//TODO: Get data from previous vehicle information (DB).
			//			tblVehicleInfo.setVisibility(View.VISIBLE);
			//			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			//			if (true/*first vehicle in users vehicle list*/) {
			//				btnLeftArrow.setVisibility(View.INVISIBLE);
			//			}

		}
		else if (v.getId() == R.id.btnAddNewVehicle) {
			//TODO: Verify Device ID.
			//Toast.makeText(this, "Device ID does not exist.", Toast.LENGTH_LONG).show();
			//TODO: Verify if all fields are filled (Toast if not).
			//Toast.makeText(this, "All fields must be filled.", Toast.LENGTH_LONG).show();
			//TODO: Save information in new line of vehicle table.
			btnUserInfo.setClickable(false);
			btnVehicleInfo.setClickable(false);
			//SAVE BUTON Toast.makeText(this, "New vehicle has been added to your profile.", Toast.LENGTH_LONG).show();
			//TODO: Extract newly added info and put it in this table.
			btnEditInfo.setVisibility(View.VISIBLE);
		}
	}

	private void initializeVisualComponents() {
		btnSave = (Button) findViewById(R.id.btnSave);
		btnCancel = (Button) findViewById(R.id.btnCancel);
		btnEditInfo = (Button) findViewById(R.id.btnEditInfo);
		btnUserInfo = (Button) findViewById(R.id.btnUserInfo);
		btnVehicleInfo = (Button) findViewById(R.id.btnVehicleInfo);

		imgButtonDouble = (ImageView) findViewById(R.id.imgButtonDouble);
		imgButtonUserInfo = (ImageView) findViewById(R.id.imgButtonUserInfo);

		tblUserText = (TableLayout) findViewById(R.id.tblUserText);
		tblUserInfo = (TableLayout) findViewById(R.id.tblUserInfo);
		tblUserTextBoxes = (TableLayout) findViewById(R.id.tblUserTextBoxes);

		txtFName = (TextView) findViewById(R.id.txtFName);
		txtLName = (TextView) findViewById(R.id.txtLName);
		txtEmail = (TextView) findViewById(R.id.txtEmail);
		txtGender = (TextView) findViewById(R.id.txtGender);
		txtBDay = (TextView) findViewById(R.id.txtBDay);
		txtPhone = (TextView) findViewById(R.id.txtPhone);
		txtAddress = (TextView) findViewById(R.id.txtAddress);
		txtPassword = (TextView) findViewById(R.id.txtPassword);

		txbFName = (EditText) findViewById(R.id.txbFName);
		txbLName = (EditText) findViewById(R.id.txbLName);
		txbEmail = (EditText) findViewById(R.id.txbEmail);
		txbGender = (EditText) findViewById(R.id.txbGender);
		txbBDay = (EditText) findViewById(R.id.txbBDay);
		txbPhone = (EditText) findViewById(R.id.txbPhone);
		txbAddress = (EditText) findViewById(R.id.txbAddress);
		txbPassword = (EditText) findViewById(R.id.txbPassword);

		btnEditInfo.setOnClickListener(this);
		btnSave.setOnClickListener(this);
		btnCancel.setOnClickListener(this);
		btnUserInfo.setOnClickListener(this);
		btnVehicleInfo.setOnClickListener(this);
	}

	private void setEditableInfo() {
		txbFName.setText(txtFName.getText());
		txbLName.setText(txtLName.getText());
		txbEmail.setText(txtEmail.getText());
		txbGender.setText(txtGender.getText());
		txbBDay.setText(txtBDay.getText());
		txbPhone.setText(txtPhone.getText());
		txbAddress.setText(txtAddress.getText());
		txbPassword.setText(txtPassword.getText());

		tblUserTextBoxes.setVisibility(View.VISIBLE);

	}
}
