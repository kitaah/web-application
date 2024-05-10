import React, { useRef, useEffect } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Link } from "@inertiajs/react";
import "swiper/swiper-bundle.css";
import "../../css/Carousel.css";
import { register } from "swiper/element";
register();

export default function Carousel({ competition }) {
    const swiperRef = useRef(null);

    useEffect(() => {
        if (swiperRef.current) {
            const swiper = swiperRef.current.swiper;
            swiper.params.slidesPerView = 1;
            swiper.params.spaceBetween = 30;
            swiper.params.loop = true;
            swiper.params.breakpoints = {
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            };
            swiper.update();
        }
    }, []);

    const handleSlideChange = (swiper) => {
        const activeIndex = swiper.activeIndex;
        const slides = document.querySelectorAll(".swiper-slide");

        for (let i = 0; i < slides.length; i++) {
            if (i !== activeIndex + 1) {
                // slides[i].style.filter = "blur(3px)";
                slides[i].style.filter = "none";
            } else {
                slides[i].style.filter = "none";
            }
        }
    };

    function Assoc({ header, name, project, img, points }) {
        const backgroundColor = header === 1 ? "#DAA520" : "#0055A4";
        const headerContent =
            header === 1
                ? "1ère place"
                : header === 2
                ? "2ème place"
                : header === 3
                ? "3ème place"
                : `${header}ème place`;

        return (
            <div className="Assoc">
                <p className="AssocRank" style={{ backgroundColor }}>
                    {headerContent}
                </p>
                <div className="AssocBody">
                    <p>{name}</p>
                    <p>{project}</p>
                    <img src={img} alt=" "></img>
                </div>
                <p className="AssocPoints" style={{ backgroundColor }}>
                    <p>POINTS</p>
                    <p>{points}</p>
                </p>
            </div>
        );
    }

    {
        /*
    return (
        <div
        className={"SwiperWrapper"}
            style={{
                width: "100%",
                boxShadow: "0px 4px 20px rgba(0, 0, 0, 0.1)",
            }}
        >
            <Swiper
                ref={swiperRef}
                className="mySwiper"
                spaceBetween={30}
                slidesPerView={1}
                loop={true}
                onSlideChange={handleSlideChange}
            >
                <SwiperSlide
                    style={{
                        textAlign: "center",
                        padding: "20px",
                    }}
                >
                    <Assoc
                        header={2}
                        name={"Association 2"}
                        project={"Projecto"}
                        img={"/assets/avatars/avatar1.png"}
                        points={"6 milliones"}
                    />
                </SwiperSlide>
                <SwiperSlide
                    style={{
                        textAlign: "center",
                        padding: "20px",
                    }}
                >
                    <Assoc
                        header={1}
                        name={"Association 1"}
                        project={"Projecto"}
                        img={"/assets/avatars/avatar1.png"}
                        points={"6 milliones"}
                    />
                </SwiperSlide>
                <SwiperSlide
                    style={{
                        textAlign: "center",
                        padding: "20px",
                    }}
                >
                    <Assoc
                        header={3}
                        name={"Association 3"}
                        project={"Projecto"}
                        img={"/assets/avatars/avatar1.png"}
                        points={"6 milliones"}
                    />
                </SwiperSlide>
                <SwiperSlide
                    style={{
                        textAlign: "center",
                        padding: "20px",
                    }}
                >
                    <Assoc
                        header={2}
                        name={"Association 2"}
                        project={"Projecto"}
                        img={"/assets/avatars/avatar1.png"}
                        points={"6 milliones"}
                    />
                </SwiperSlide>
                <SwiperSlide
                    style={{
                        textAlign: "center",
                        padding: "20px",
                    }}
                >
                    <Assoc
                        header={1}
                        name={"Association 1"}
                        project={"Projecto"}
                        img={"/assets/avatars/avatar1.png"}
                        points={"6 milliones"}
                    />
                </SwiperSlide>
                <SwiperSlide
                    style={{
                        textAlign: "center",
                        padding: "20px",
                    }}
                >
                    <Assoc
                        header={3}
                        name={"Association 3"}
                        project={"Projecto"}
                        img={"/assets/avatars/avatar1.png"}
                        points={"6 milliones"}
                    />
                </SwiperSlide>
            </Swiper>
        </div>
    );
*/
    }
    return (
        <div
            className={"SwiperWrapper"}
            style={{
                width: "100%",
                boxShadow: "0px 4px 20px rgba(0, 0, 0, 0.1)",
            }}
        >
            {competition.map(
                ({
                    id,
                    name,
                    competition,
                    association_first,
                    association_second,
                    association_third,
                }) => (
                    <Swiper
                        key={id}
                        ref={swiperRef}
                        className="mySwiper"
                        spaceBetween={30}
                        slidesPerView={1}
                        loop={true}
                        onSlideChange={handleSlideChange}
                    >
                        <SwiperSlide
                            style={{
                                textAlign: "center",
                                padding: "20px",
                            }}
                        >
                            <Assoc
                                header={2}
                                name={association_second.name}
                                project={
                                    <Link
                                        href={`/association/${association_second.slug}`}
                                    >
                                        <button className="px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">
                                            Détails
                                        </button>
                                    </Link>
                                }
                                img={association_second.image}
                                points={association_second.points}
                            />
                        </SwiperSlide>
                        <SwiperSlide
                            style={{
                                textAlign: "center",
                                padding: "20px",
                            }}
                        >
                            <Assoc
                                header={1}
                                name={association_first.name}
                                project={
                                    <Link
                                        href={`/association/${association_first.slug}`}
                                    >
                                        <button className="px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">
                                            Détails
                                        </button>
                                    </Link>
                                }
                                img={association_first.image}
                                points={association_first.points}
                            />
                        </SwiperSlide>
                        <SwiperSlide
                            style={{
                                textAlign: "center",
                                padding: "20px",
                            }}
                        >
                            <Assoc
                                header={3}
                                name={association_third.name}
                                project={
                                    <Link
                                        href={`/association/${association_third.slug}`}
                                    >
                                        <button className="px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">
                                            Détails
                                        </button>
                                    </Link>
                                }
                                img={association_third.image}
                                points={association_third.points}
                            />
                        </SwiperSlide>
                        <SwiperSlide
                            style={{
                                textAlign: "center",
                                padding: "20px",
                            }}
                        >
                            <Assoc
                                header={2}
                                name={association_second.name}
                                project={
                                    <Link
                                        href={`/association/${association_second.slug}`}
                                    >
                                        <button className="px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">
                                            Détails
                                        </button>
                                    </Link>
                                }
                                img={association_second.image}
                                points={association_second.points}
                            />
                        </SwiperSlide>
                        <SwiperSlide
                            style={{
                                textAlign: "center",
                                padding: "20px",
                            }}
                        >
                            <Assoc
                                header={1}
                                name={association_first.name}
                                project={
                                    <Link
                                        href={`/association/${association_first.slug}`}
                                    >
                                        <button className="px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">
                                            Détails
                                        </button>
                                    </Link>
                                }
                                img={association_first.image}
                                points={association_first.points}
                            />
                        </SwiperSlide>
                        <SwiperSlide
                            style={{
                                textAlign: "center",
                                padding: "20px",
                            }}
                        >
                            <Assoc
                                header={3}
                                name={association_third.name}
                                project={
                                    <Link
                                        href={`/association/${association_third.slug}`}
                                    >
                                        <button className="px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">
                                            Détails
                                        </button>
                                    </Link>
                                }
                                img={association_third.image}
                                points={association_third.points}
                            />
                        </SwiperSlide>
                    </Swiper>
                )
            )}
        </div>
    );
}
