package lab1;

import java.util.Arrays;
import java.util.List;

public class P1{
    /*
     * Să se determine ultimul (din punct de vedere alfabetic)
     * cuvânt care poate apărea într-un text care conține mai multe cuvinte
     * separate prin ” ” (spațiu). De ex. ultimul (dpdv alfabetic) cuvânt din
     * ”Ana are mere rosii si galbene” este cuvântul "si".
     */
    public static void miniMaxSum(List<Integer> arr) {
        List<Integer> sorted=arr.stream().sorted().toList();
        int n=arr.size();
        int first_number=sorted.get(0)+sorted.get(1)+sorted.get(2)+sorted.get(3);
        int second_number=sorted.get(n-1)+sorted.get(n-2)+sorted.get(n-3)+sorted.get(n-4);
        System.out.println(String.valueOf(first_number)+String.valueOf(second_number));


    }
    public static void main(String[] args) {
        List<Integer> arr= Arrays.asList(1,2,3,4,5);
        miniMaxSum(arr);
    }
}