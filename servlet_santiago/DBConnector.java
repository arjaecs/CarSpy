import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class DBConnector {
	private Connection conn = null;	
	private String host = "jdbc:mysql://localhost:3306/carspy";
	private String username = "root";
	private String password = "aiYai8U";
	private static DBConnector db;
	private final static String INSERT_SESSION = "INSERT INTO Session (vehicleID, date, time, lat, Session.long," 
			+ " path1, path2, path3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

	public static void main(String[] args) throws SQLException {
		DBConnector dbConn = DBConnector.getConnector();
		String fields[] = {"1337", "2013-04-07", "03:05:23", "18.476", "-66.788", "spypics/CarSpy2.jpg", "spypics/CarSpy2.jpg", "spypics/CarSpy2.jpg"};
		dbConn.connect();
		dbConn.runQuery(INSERT_SESSION,  fields);
		dbConn.disconnect();
	}

	public static DBConnector getConnector() {
		if (db == null){
			db = new DBConnector();

			return db;
		}
		else{
			return db;
		}
	}

	public boolean connect() {
		try {
			this.conn = DriverManager.getConnection(host, username, password);
			System.out.println("Connection successful.");
			return true;
		} 
		catch (SQLException e) {
			System.out.println(e.getMessage());
			return false;
		}
	}

	public void disconnect(){
		try {
			this.conn.close();
		} 
		catch (SQLException e) {
			System.out.println(e.getMessage());
		}
	}

	public ResultSet runQuery(String statement, String[] fields) throws SQLException {
		ResultSet resultSet = null;
		this.conn.setAutoCommit(false);
		PreparedStatement preStatement = conn.prepareStatement(statement);
		for (int i = 0; i < fields.length; i++) {
			int j = i + 1;
			preStatement.setString(j, fields[i]);
		}
		System.out.println(preStatement.toString());
		preStatement.addBatch();
		preStatement.executeBatch();
		resultSet = preStatement.getResultSet();
		this.conn.commit();

		return resultSet;
	}

}