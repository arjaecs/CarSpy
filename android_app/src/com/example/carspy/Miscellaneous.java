package com.example.carspy;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.ArrayList;
import java.util.Random;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;

public class Miscellaneous {
	static final String AB = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	static Random rnd = new Random();

	public static String getMD5(String password) {
		try {
			MessageDigest md = MessageDigest.getInstance("MD5");
			byte[] messageDigest = md.digest(password.getBytes());
			BigInteger number = new BigInteger(1, messageDigest);
			String hashtext = number.toString(16);

			while (hashtext.length() < 32) {
				hashtext = "0" + hashtext;
			}

			return hashtext;
		}
		catch (NoSuchAlgorithmException e) {
			throw new RuntimeException(e);
		}
	}

	public static String generatePassword() {
		int len = 10;
		StringBuilder sb = new StringBuilder(len);
		for (int i = 0; i < len; i++) {
			sb.append(AB.charAt(rnd.nextInt(AB.length())));
		}

		return sb.toString();
	}

	public static ProgressDialog OKProgressDialog(Context context, String message) {
		ProgressDialog pDialog = new ProgressDialog(context); 
		pDialog.setCanceledOnTouchOutside(false);
		pDialog.setMessage(message);
		pDialog.setButton(DialogInterface.BUTTON_NEGATIVE, "OK", new DialogInterface.OnClickListener() {
			@Override
			public void onClick(DialogInterface dialog, int which) {
				dialog.dismiss();
			}
		});

		return pDialog;
	}

	public static ProgressDialog NormalProgressDialog(Context context, String message) {
		ProgressDialog pDialog = new ProgressDialog(context); 
		pDialog.setCanceledOnTouchOutside(false);
		pDialog.setMessage(message);
		pDialog.setIndeterminate(false);
		pDialog.setCancelable(true);

		return pDialog;
	}
}
