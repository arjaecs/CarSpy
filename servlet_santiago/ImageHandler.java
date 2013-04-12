import java.io.BufferedWriter;
import java.io.DataOutputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Scanner;


public class ImageHandler {
	private final static String TEXT_PATH = "test.txt";
	private final static String IMAGE_PATH = "/var/www/spypics/test.jpg";

	public static void main(String[] args) {
		//		try {
		//			String example[] = {"01", "FF"};
		//			updateTextFile(example);
		createImage();
		//		} 
		//		catch (FileNotFoundException e) {
		//			System.out.println("Error: " + e.getMessage());
		//		}
	}

	public static void updateTextFile(String[] dataArray) throws FileNotFoundException {
		try {
			BufferedWriter writer = new BufferedWriter(new FileWriter(TEXT_PATH));
			for ( int i = 0; i < dataArray.length; i++) {      
				writer.write(dataArray[i] + " ");
			}
			writer.close();
		} 
		catch(IOException e) {
			System.out.println("Error: " + e.getMessage());
		}
	}

	public static void createImage() {
		try {
			Scanner parser = new Scanner(new FileReader(TEXT_PATH));
			DataOutputStream output = new DataOutputStream(new FileOutputStream(IMAGE_PATH));

			String hex = null;

			while (parser.hasNext()){
				hex = parser.next();
				int num = Integer.parseInt(hex, 16);
				System.out.println("This is long: " + num);
				output.write(num);
			}

			output.close();
			System.out.println("Image converted successfuly.");
		} 
		catch (FileNotFoundException e) {
			System.out.println("Error: " + e.getMessage());
		} 
		catch (IOException e) {
			System.out.println("Error: " + e.getMessage());
		}
	}
}
