import logoMarianne from "../../../public/assets/Logo_Marianne.svg";
import logo from "../../../public/assets/RessourcesRelationnelles.jpg";

export default function ApplicationLogo(props) {
    return (
        <div className={props.className}>
            <img
                style={{ maxHeight: "100%" }}
                src={logo}
                alt="Logo Ressources Relationnelles"
            />
        </div>
    );
}
