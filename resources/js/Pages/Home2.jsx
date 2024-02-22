import { usePage } from "@inertiajs/react";
import { Header } from "@codegouvfr/react-dsfr/Header";
import { Button } from "flowbite-react";

export default function Home2() {
    return (
        <>
            <Header></Header>
            <div style={{ margin: "1%" }}>
                <Button>Click me</Button>
            </div>
        </>
    );
}
