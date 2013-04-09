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

public class VehicleInfo extends Activity implements OnClickListener {
	private boolean startUp = false;
	private boolean addNewMode = false;
	private Button btnSave;
	private Button btnCancel;
	private Button btnUserInfo;
	private Button btnVehicleInfo;
	private Button btnAddNewVehicle;
	private Button btnEditInfoSmall;
	private ImageButton btnLeftArrow;
	private ImageButton btnRightArrow;
	private ImageView imgButtonDouble;
	private TableLayout tblVehicleInfo;
	private TableLayout tblVehicleTextBoxes;
	private TextView txtDeviceID;
	private TextView txtMake;
	private TextView txtModel;
	private TextView txtYear;
	private TextView txtColor;
	private TextView txtLicensePlate;
	private EditText txbDeviceID;
	private EditText txbMake;
	private EditText txbModel;
	private EditText txbYear;
	private EditText txbColor;
	private EditText txbLicensePlate;

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.vehicle_info);

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
				Intent mainActivity = new Intent(VehicleInfo.this, Main.class);
				startActivity(mainActivity);
			}
			else if (chosenOption.equals("Logout")) {
				Intent loginActivity = new Intent(VehicleInfo.this, Login.class);
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
		if (v.getId() == R.id.btnEditInfoSmall) {
			addNewMode = false;
			btnSave.setVisibility(View.VISIBLE);
			btnCancel.setVisibility(View.VISIBLE);
			imgButtonDouble.setVisibility(View.VISIBLE);
			btnUserInfo.setClickable(false);
			btnVehicleInfo.setClickable(false);
			tblVehicleInfo.setVisibility(View.INVISIBLE);
			btnLeftArrow.setVisibility(View.INVISIBLE);
			btnRightArrow.setVisibility(View.INVISIBLE);
			btnAddNewVehicle.setVisibility(View.INVISIBLE);
			btnEditInfoSmall.setVisibility(View.INVISIBLE);

			setEditableInfo();
		}
		else if (v.getId() == R.id.btnCancel) {
			imgButtonDouble.setVisibility(View.VISIBLE);
			btnSave.setVisibility(View.INVISIBLE);
			btnCancel.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);
			btnAddNewVehicle.setVisibility(View.VISIBLE);
			btnEditInfoSmall.setVisibility(View.VISIBLE);
			tblVehicleInfo.setVisibility(View.VISIBLE);
			//TODO: If user has multiple vehicles
			btnLeftArrow.setVisibility(View.VISIBLE);
			btnRightArrow.setVisibility(View.VISIBLE);
		}
		else if (v.getId() == R.id.btnSave) {
			//TODO: Update information in DB.
			//TODO: Extract info from DB to display again.

			if (addNewMode) {
				Toast.makeText(this, "New vehicle has been added.", Toast.LENGTH_LONG).show();
				//TODO: Add new vehicle in DB.
			}
			else {
				Toast.makeText(this, "Vehicle information has been updated.", Toast.LENGTH_LONG).show();
				//TODO: Update vehicle information in DB.
			}
			btnSave.setVisibility(View.INVISIBLE);
			btnCancel.setVisibility(View.INVISIBLE);
			imgButtonDouble.setVisibility(View.VISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);
			tblVehicleInfo.setVisibility(View.VISIBLE);
			btnLeftArrow.setVisibility(View.VISIBLE);
			btnRightArrow.setVisibility(View.VISIBLE);
			btnAddNewVehicle.setVisibility(View.VISIBLE);
			btnEditInfoSmall.setVisibility(View.VISIBLE);
		}
		else if (v.getId() == R.id.btnUserInfo) {
			Intent userInfoActivity = new Intent(VehicleInfo.this, UserInfo.class);
			startActivity(userInfoActivity);
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
			addNewMode = true;
			//TODO: Verify Device ID.
			//Toast.makeText(this, "Device ID does not exist.", Toast.LENGTH_LONG).show();
			//TODO: Verify if all fields are filled (Toast if not).
			//Toast.makeText(this, "All fields must be filled.", Toast.LENGTH_LONG).show();
			//TODO: Save information in new line of vehicle table.
			btnUserInfo.setClickable(false);
			btnVehicleInfo.setClickable(false);
			//TODO: Extract newly added info and put it in this table.
			tblVehicleInfo.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.VISIBLE);
			btnSave.setVisibility(View.VISIBLE);
			btnCancel.setVisibility(View.VISIBLE);
			btnAddNewVehicle.setVisibility(View.INVISIBLE);
			btnEditInfoSmall.setVisibility(View.INVISIBLE);
			btnLeftArrow.setVisibility(View.INVISIBLE);
			btnRightArrow.setVisibility(View.INVISIBLE);
		}
	}


	private void initializeVisualComponents() {
		btnSave = (Button) findViewById(R.id.btnSave);
		btnCancel = (Button) findViewById(R.id.btnCancel);
		btnUserInfo = (Button) findViewById(R.id.btnUserInfo);
		btnVehicleInfo = (Button) findViewById(R.id.btnVehicleInfo);
		btnAddNewVehicle = (Button) findViewById(R.id.btnAddNewVehicle);
		btnEditInfoSmall = (Button) findViewById(R.id.btnEditInfoSmall);
		btnLeftArrow = (ImageButton) findViewById(R.id.btnLeftArrow);
		btnRightArrow = (ImageButton) findViewById(R.id.btnRightArrow);

		imgButtonDouble = (ImageView) findViewById(R.id.imgButtonDouble);
		
		tblVehicleInfo = (TableLayout) findViewById(R.id.tblVehicleInfo);
		tblVehicleTextBoxes = (TableLayout) findViewById(R.id.tblVehicleTextBoxes);

		txtDeviceID = (TextView) findViewById(R.id.txtDeviceID);
		txtMake = (TextView) findViewById(R.id.txtMake);
		txtModel = (TextView) findViewById(R.id.txtModel);
		txtYear = (TextView) findViewById(R.id.txtYear);
		txtColor = (TextView) findViewById(R.id.txtColor);
		txtLicensePlate = (TextView) findViewById(R.id.txtLicensePlate);

		txbDeviceID = (EditText) findViewById(R.id.txbDeviceID);
		txbMake = (EditText) findViewById(R.id.txbMake);
		txbModel = (EditText) findViewById(R.id.txbModel);
		txbYear = (EditText) findViewById(R.id.txbYear);
		txbColor = (EditText) findViewById(R.id.txbColor);
		txbLicensePlate = (EditText) findViewById(R.id.txbLicensePlate);

		btnSave.setOnClickListener(this);
		btnCancel.setOnClickListener(this);
		btnUserInfo.setOnClickListener(this);
		btnVehicleInfo.setOnClickListener(this);
		btnLeftArrow.setOnClickListener(this);
		btnRightArrow.setOnClickListener(this);
		btnAddNewVehicle.setOnClickListener(this);
		btnEditInfoSmall.setOnClickListener(this);
	}

	private void setEditableInfo() {
		txbDeviceID.setText(txtDeviceID.getText());
		txbMake.setText(txtMake.getText());
		txbModel.setText(txtModel.getText());
		txbYear.setText(txtYear.getText());
		txbColor.setText(txtColor.getText());
		txbLicensePlate.setText(txtLicensePlate.getText());

		tblVehicleTextBoxes.setVisibility(View.VISIBLE);
	}
}
