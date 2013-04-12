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
	private Button btnSave;
	private Button btnCancel;
	private Button btnEditInfo;
	private Button btnUserInfo;
	private Button btnVehicleInfo;

	private ImageView imgButtonDouble;
	private ImageView imgButtonUserInfo;
	private TableLayout tblUserText;
	private TableLayout tblUserInfo;
	private TableLayout tblUserTextBoxes;

	private TextView txtFName;
	private TextView txtLName;
	private TextView txtEmail;
	private TextView txtGender;
	private TextView txtBDay;
	private TextView txtPhone;
	private TextView txtAddress;
	private TextView txtPassword;

	private EditText txbFName;
	private EditText txbLName;
	private EditText txbEmail;
	private EditText txbGender;
	private EditText txbBDay;
	private EditText txbPhone;
	private EditText txbAddress;
	private EditText txbPassword;
	private User user;

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

		user = new User("email@host.com", "********", "fname", "lname", "Male", "2012-02-10", "888-888-8888", "home address");

		updateTxtTable();
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
			setTextBoxes();
			btnEditInfo.setVisibility(View.INVISIBLE);
			btnSave.setVisibility(View.VISIBLE);
			btnCancel.setVisibility(View.VISIBLE);
			imgButtonDouble.setVisibility(View.VISIBLE);
			btnUserInfo.setClickable(false);
			btnVehicleInfo.setClickable(false);
			tblUserInfo.setVisibility(View.INVISIBLE);
			tblUserTextBoxes.setVisibility(View.VISIBLE);
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
			setTxtInfo();
			updateTxtTable();
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
		else if (v.getId() == R.id.btnVehicleInfo) {
			Intent vehicleInfoActivity = new Intent(UserInfo.this, VehicleInfo.class);
			startActivity(vehicleInfoActivity);
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

	private void setTextBoxes() {
		txbFName.setText(txtFName.getText());
		txbLName.setText(txtLName.getText());
		txbEmail.setText(txtEmail.getText());
		txbGender.setText(txtGender.getText());
		txbBDay.setText(txtBDay.getText());
		txbPhone.setText(txtPhone.getText());
		txbAddress.setText(txtAddress.getText());
		txbPassword.setText(txtPassword.getText());
	}

	private void updateTxtTable() {
		txtFName.setText(user.getFirstName());
		txtLName.setText(user.getLastName());
		txtEmail.setText(user.getEmail());
		txtGender.setText(user.getGender());
		txtBDay.setText(user.getBirth());
		txtPhone.setText(user.getPhone());
		txtAddress.setText(user.getAddress());
		txtPassword.setText("********");
	}
	
	private void setTxtInfo() {
		user.setFirstName(txbFName.getText().toString());
		user.setLastName(txbLName.getText().toString());
		user.setEmail(txbEmail.getText().toString());
		user.setGender(txbGender.getText().toString());
		user.setBirth(txbBDay.getText().toString());
		user.setPhone(txbPhone.getText().toString());
		user.setAddress(txbAddress.getText().toString());
		user.setPassword(txbPassword.getText().toString());
	}

	private class User {
		private String email;
		private String password;
		private String firstName;
		private String lastName;
		private String gender;
		private String birth;
		private String phone;
		private String address;


		public User(String email, String password, String firstName, String lastName,
				String gender, String birth, String phone, String address) {
			super();
			this.email = email;
			this.password = password;
			this.firstName = firstName;
			this.lastName = lastName;
			this.gender = gender;
			this.birth = birth;
			this.phone = phone;
			this.address = address;
		}

		public void setEmail(String email) {
			this.email = email;
		}
		public void setPassword(String password) {
			this.password = password;
		}
		public void setFirstName(String firstName) {
			this.firstName = firstName;
		}
		public void setLastName(String lastName) {
			this.lastName = lastName;
		}
		public void setGender(String gender) {
			this.gender = gender;
		}
		public void setBirth(String birth) {
			this.birth = birth;
		}
		public void setPhone(String phone) {
			this.phone = phone;
		}
		public void setAddress(String address) {
			this.address = address;
		}

		public String getEmail() {
			return email;
		}
		public String getPassword() {
			return password;
		}
		public String getFirstName() {
			return firstName;
		}
		public String getLastName() {
			return lastName;
		}
		public String getGender() {
			return gender;
		}
		public String getBirth() {
			return birth;
		}
		public String getPhone() {
			return phone;
		}
		public String getAddress() {
			return address;
		}

	}
}
