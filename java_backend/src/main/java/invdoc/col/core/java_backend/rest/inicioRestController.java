package invdoc.col.core.java_backend.rest;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class inicioRestController {

    @GetMapping("/")
    public String inicio(){

        return "Página de inicio";
    }
}
